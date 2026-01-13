from pydantic import BaseModel
import requests
from log import logger
from lib.classes import VehicleInfo




def getVehicleInfo(licensePlate: str) -> VehicleInfo | None:
    url = f"https://opendata.rdw.nl/resource/m9d7-ebf2.json?$where=kenteken%20LIKE%20%27{licensePlate.upper()}%27&$select=kenteken,merk,handelsbenaming,eerste_kleur,voertuigsoort"
    response = requests.get(url)
    jsonData = response.json()
    if len(jsonData) == 0:
        return None
    data = jsonData[0]
    return VehicleInfo(license_plate=data["kenteken"], make=data["merk"], model=data["handelsbenaming"], vehicle_type=data["voertuigsoort"], color=data["eerste_kleur"]) if data else None
def dashLicensePlate(license_plate: str) -> str:
    newLicensePlate = ""
    
    lastCharIsdigit = None
    for char in license_plate:
        if char.isdigit() != lastCharIsdigit:
            newLicensePlate += "-"
            lastCharIsdigit = char.isdigit()
        newLicensePlate += char
    newLicensePlate = newLicensePlate.strip("-")
    parts = []
    for part in newLicensePlate.split("-"):
        if len(part) == 4:
            parts.append(part[:2])
            parts.append(part[2:])
        else:
            parts.append(part)
    newLicensePlate = "-".join(parts)
    return newLicensePlate
