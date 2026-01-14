from datetime import datetime
from pydantic import BaseModel
import auth
from fastapi import APIRouter, HTTPException
from sqlmodel import select
import requests

import db
from lib import classes, sqlClasses, vehicleInfo


router = APIRouter(prefix="/v1", tags=["v1"])


@router.get("")
@router.get("/")
async def get_sortTypes():
    return {"message": "Hello World"}


@router.get("/needAuth")
async def needAuth(current_user: auth.LoggedIn):
    return {"message": "you are authenticated"}


@router.get("/needAdmin")
async def needAdmin(current_user: auth.Admin):
    return {"message": "you are admin"}


class NumberplateData(BaseModel):
    kenteken: str
    merk: str
    handelsbenaming: str


@router.get("/numberplate/{numberplate}", response_model=list[NumberplateData])
async def get_numberplate(numberplate: str) -> list[NumberplateData]:
    url = f"https://opendata.rdw.nl/resource/m9d7-ebf2.json?$where=kenteken%20LIKE%20%27{numberplate.upper()}%25%27&$select=kenteken,merk,handelsbenaming"
    response = requests.get(url)
    data = response.json()
    return [NumberplateData(**item) for item in data]


class RegisterCarResponse(BaseModel):
    message: str
    car: sqlClasses.Car


@router.post("/car/register")
async def register_car(
    session: db.session,
    current_user: auth.LoggedIn,
    license_plate: str,
    notes: str | None = None,
) -> RegisterCarResponse:
    if not vehicleInfo.getVehicleInfo(license_plate):
        raise HTTPException(status_code=400, detail="Vehicle not found in RDW database")
    newCar = sqlClasses.Car(
        license_plate=license_plate, notes=notes, owner_id=current_user.id
    )
    session.add(newCar)
    session.commit()
    session.refresh(newCar)
    return RegisterCarResponse(message="Car registered", car=newCar)


@router.get("/cars", response_model=list[classes.FullCarData])
async def get_cars(session: db.session, current_user: auth.LoggedIn):
    cars = list(
        session.exec(
            select(sqlClasses.Car).where(sqlClasses.Car.owner_id == current_user.id)
        ).all()
    )
    carInfo = []
    for car in cars:
        currentVehicleInfo = vehicleInfo.getVehicleInfo(car.license_plate)
        if currentVehicleInfo:
            dictA = dict(car)
            dictB = dict(currentVehicleInfo)
            combinedDict = dictA | dictB
            combinedDict["license_plate"] = vehicleInfo.dashLicensePlate(
                combinedDict["license_plate"]
            )
            carInfo.append(classes.FullCarData(**combinedDict))
    return carInfo


@router.post("/car/appointment/add")
async def add_appointment(
    session: db.session,
    current_user: auth.LoggedIn,
    car_id: str,
    start_time: str,
    end_time: str,
    date: str,
    description: str,
):
    try:
        datetime.strptime(date, "%Y-%m-%d")
    except ValueError:
        raise HTTPException(status_code=400, detail="Invalid date format. Format Should be YYYY-MM-DD")
    try:
        start_time_dt: datetime = datetime.strptime(f"{date}*/*{start_time}", "%Y-%m-%d*/*%H:%M")
    except ValueError:
        raise HTTPException(status_code=400, detail="Invalid start time format. Format Should be HH:MM")
    try:
        end_time_dt: datetime = datetime.strptime(f"{date}*/*{end_time}", "%Y-%m-%d*/*%H:%M")
    except ValueError:
        raise HTTPException(status_code=400, detail="Invalid end time format. Format Should be HH:MM")
    if start_time_dt < datetime.now():
        raise HTTPException(status_code=400, detail="Date is in the past")
    if start_time_dt > end_time_dt:
        raise HTTPException(status_code=400, detail="Start time is after end time")
    car = session.exec(
        select(sqlClasses.Car).where(sqlClasses.Car.id == car_id)
    ).one_or_none()
    if not car:
        raise HTTPException(status_code=404, detail="Car not found")
    if car.owner_id != current_user.id:
        raise HTTPException(status_code=403, detail="Not your car")
    if session.exec(select(sqlClasses.Appointment).where(sqlClasses.Appointment.start_time >= start_time_dt).where(sqlClasses.Appointment.end_time <= end_time_dt)).one_or_none():
        raise HTTPException(status_code=400, detail="An appointment already exists for this time")
    
    appointment = sqlClasses.Appointment(
        start_time=start_time_dt,
        end_time=end_time_dt,
        description=description,
        car_id=car_id,
    )
    session.add(appointment)
    session.commit()
    return {"message": "Appointment added successfully"}


@router.get("/car/appointments")
async def get_appointments(session: db.session, current_user: auth.LoggedIn):
    appointments = list(
        session.exec(
            select(sqlClasses.Appointment).where(
                sqlClasses.Appointment.car_id == current_user.cars[0].id
            )
        ).all()
    )
    return appointments
