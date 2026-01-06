import db
import auth
from log import logger
from lib.helpers import col
from lib import sqlClasses
from sqlmodel import or_, select
from typing_extensions import Annotated
from fastapi import APIRouter, Depends, HTTPException


router = APIRouter(prefix="/v1")
@router.get("/")
async def get_sortTypes():
    return {"message": "Hello World"}