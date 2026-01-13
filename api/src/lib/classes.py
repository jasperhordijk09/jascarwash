from datetime import datetime
from types import FunctionType
from typing import Optional, Union
from sqlalchemy import ColumnElement
from collections.abc import Callable
from pydantic import BaseModel, ConfigDict

from lib import sqlClasses


class VehicleInfo(BaseModel):
    license_plate: str
    make: str
    model: str
    vehicle_type: str
    color: str
class FullCarData(VehicleInfo):
    id: str
    license_plate: str
    created_at: datetime
    notes: Optional[str]
    owner_id: Optional[str]

    