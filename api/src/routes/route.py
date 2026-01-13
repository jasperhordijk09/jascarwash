from pydantic import BaseModel
import auth
from fastapi import APIRouter
import requests

import db
from lib import sqlClasses


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


@router.post("/car/register")
async def register_car(
    session: db.session,
    current_user: auth.LoggedIn,
    license_plate: str,
    notes: str | None = None,
):
    newCar = sqlClasses.Car(
        license_plate=license_plate, notes=notes, owner_id=current_user.id
    )
    session.add(newCar)
    session.commit()
    return {"message": "Car registered successfully", "car": newCar}
