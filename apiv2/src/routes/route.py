import auth
from fastapi import APIRouter


router = APIRouter(prefix="/v1",tags=["v1"])
@router.get("/")
async def get_sortTypes():
    return {"message": "Hello World"}
@router.get("/needAuth")
async def needAuth(current_user: auth.LoggedIn):
    return {"message": "you are authenticated"}
@router.get("/needAdmin")
async def needAdmin(current_user: auth.Admin):
    return {"message": "you are admin"}
