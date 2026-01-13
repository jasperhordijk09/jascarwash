from pydantic import BaseModel
import requests
from log import logger
from lib.classes import VehicleInfo




def get_vehicle_info(license_plate: str) -> VehicleInfo | None:
    url = f"https://opendata.rdw.nl/resource/m9d7-ebf2.json?$where=kenteken%20LIKE%20%27{license_plate.upper()}%27&$select=kenteken,merk,handelsbenaming,eerste_kleur,voertuigsoort"
    response = requests.get(url)
    data = response.json()[0]
    logger.debug(data)
    return VehicleInfo(license_plate=data["kenteken"], make=data["merk"], model=data["handelsbenaming"], vehicle_type=data["voertuigsoort"], color=data["eerste_kleur"]) if data else None
