import jwt
import secrets
from log import logger
from pydantic import BaseModel
from sqlmodel import func, select
from typing import Annotated, Literal, Optional
from passlib.context import CryptContext
from jwt.exceptions import InvalidTokenError
from datetime import datetime, timedelta, timezone
from fastapi import APIRouter, Depends, HTTPException, status, Response, Request


import db
from lib import sqlClasses

ALGORITHM = "HS256"
ACCESS_TOKEN_EXPIRE_SECONDS = 900
# SECRET_KEY = secrets.token_hex(64)
SECRET_KEY = 'a3286f50cf9c2fb7fea67a70fcd26d343f9e0d97bb30ef214f2b2a68c0fca62ecce10ab809badea996d9c3db883375238fb4395ce88a7b2e5a026e451d8c6610'
COOKIE_NAME = "jascarwash_access_token"

router = APIRouter(prefix="/auth", tags=["auth"])
deleteAuthCookie = {
    "key": COOKIE_NAME,
    "httponly": True,
    "secure": False,
    "samesite": "strict",
}
authCookie = {**deleteAuthCookie, "max_age": ACCESS_TOKEN_EXPIRE_SECONDS}


def initDb(session: db.session):
    default_user = sqlClasses.User(
        username="admin",
        full_name="admin account",
        permissions=3,
        email="admin@admin.com",
        hashed_password="$2b$12$JNu0b.mY6R82keoc02BqOODWFUr93MMP/DW817Kk0lcil3YTnhNjy",
    )
    active_count = session.exec(
        select(func.count())
        .select_from(sqlClasses.User)
        .where(sqlClasses.User.disabled == False)
    ).one()
    if active_count == 0:
        logger.debug("creating default admin user")
        session.add(default_user)
        session.commit()


class Token(BaseModel):
    access_token: str
    token_type: str
    expire: int = ACCESS_TOKEN_EXPIRE_SECONDS


class TokenData(BaseModel):
    username: str | None = None


pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")


def verify_password(plain_password, hashed_password):
    return pwd_context.verify(plain_password, hashed_password)


def get_password_hash(password):
    return pwd_context.hash(password)


def get_user(username: str, session: db.session) -> None | sqlClasses.User:
    return session.exec(
        select(sqlClasses.User).where(sqlClasses.User.username == username)
    ).first()


def authenticate_user(
    username: str, password: str, session: db.session
) -> sqlClasses.User | Literal[False]:
    user = get_user(username, session=session)
    if not user:
        return False
    if not verify_password(password, user.hashed_password):
        return False
    if user.disabled:
        return False
    return user


def create_access_token(data: dict, expires_delta: timedelta | None = None):
    to_encode = data.copy()
    if expires_delta:
        expire = datetime.now(timezone.utc) + expires_delta
    else:
        expire = datetime.now(timezone.utc) + timedelta(
            seconds=ACCESS_TOKEN_EXPIRE_SECONDS
        )
    to_encode.update({"exp": expire})
    encoded_jwt = jwt.encode(to_encode, SECRET_KEY, algorithm=ALGORITHM)
    return encoded_jwt


async def get_token_from_cookie(request: Request) -> str:
    token = request.cookies.get(COOKIE_NAME)
    if not token:
        logger.error("no token provided")
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Not authenticated",
        )
    logger.debug(f"token ✅")
    return token


async def get_current_user(
    token: Annotated[str, Depends(get_token_from_cookie)], session: db.session
) -> sqlClasses.User:
    credentials_exception = HTTPException(
        status_code=status.HTTP_401_UNAUTHORIZED,
        detail="Could not validate credentials",
    )
    try:
        payload = jwt.decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        username: str | None = payload.get("sub")
        if username is None:
            logger.error("no username provided")
            raise credentials_exception
        token_data = TokenData(username=username)
    except InvalidTokenError:
        logger.error("invalid token")
        raise credentials_exception
    if token_data.username is None:
        logger.error("no username provided")
        raise credentials_exception
    user: sqlClasses.User | None = get_user(
        username=token_data.username, session=session
    )
    if user is None:
        logger.error("user not found")
        raise credentials_exception
    return user


LoggedIn = Annotated[sqlClasses.User, Depends(get_current_user)]


async def admin_required(current_user: LoggedIn):
    if current_user.permissions < 3:
        raise HTTPException(
            status_code=status.HTTP_403_FORBIDDEN,
            detail="Insufficient permissions",
        )


Admin = Annotated[sqlClasses.User, Depends(admin_required)]


class LoginData(BaseModel):
    username: str
    password: str


@router.post("/login")
async def login_for_access_token(
    response: Response, login_data: Annotated[LoginData, Depends()], session: db.session
):
    user = authenticate_user(login_data.username, login_data.password, session=session)
    if not user:
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Incorrect username or password",
        )
    access_token_expires = timedelta(seconds=ACCESS_TOKEN_EXPIRE_SECONDS)
    access_token = create_access_token(
        data={"sub": user.username}, expires_delta=access_token_expires
    )

    # set HttpOnly cookie
    response.set_cookie(**authCookie, value=access_token)

    return {"message": "Login successful"}


class LogoutReturn(BaseModel):
    message: str


@router.post("/logout")
async def logout(response: Response) -> LogoutReturn:
    response.delete_cookie(**deleteAuthCookie)
    return LogoutReturn(message="Logged out successfully")


class PasswordHashReturn(BaseModel):
    hashed_password: str


@router.post("/generate-hash")
async def generate_hash(password) -> PasswordHashReturn:
    hashed_password = get_password_hash(password)
    return PasswordHashReturn(hashed_password=hashed_password)


@router.get("/whoami")
async def who_is_current_user(
    current_user: LoggedIn,
) -> sqlClasses.User:
    return current_user


@router.get("/user/{username}")
async def get_user_info(
    username: str,
    current_user: Admin,
    session: db.session,
):
    user = get_user(username, session)
    if not user:
        raise HTTPException(status_code=404, detail="User not found")
    return sqlClasses.User(**dict(user))



@router.post("/register")
async def register_user(
    session: db.session,
    username: str,
    password: str,
    full_name: Optional[str] = None,
    email: Optional[str] = None,
):
    passwordHash = get_password_hash(password)
    session.add(
        sqlClasses.User(
            username=username,
            full_name=full_name,
            email=email,
            hashed_password=passwordHash,
        )
    )
    newuser = get_user(username, session)
    if not newuser:
        raise HTTPException(status_code=500, detail="User registration failed")
    return {
        "message": "User registered successfully",
        "user": sqlClasses.User(**dict(newuser)),
    }


@router.post("/disable-user")
async def disable_user(
    username: str,
    current_user: Admin,
    session: db.session,
):
    user = get_user(username, session=session)
    if not user:
        raise HTTPException(status_code=404, detail="User not found")
    user.disabled = True
    u = sqlClasses.User(**dict(user))
    session.add(user)
    session.commit()
    return {"message": "User disabled successfully", "user": u}


@router.post("/enable-user")
async def enable_user(
    username: str,
    current_user: Admin,
    session: db.session,
):
    user = get_user(username, session=session)
    if not user:
        raise HTTPException(status_code=404, detail="User not found")
    user.disabled = False
    u = sqlClasses.User(**dict(user))
    session.add(user)
    session.commit()
    return {"message": "User disabled successfully", "user": u}


@router.post("/change-password")
async def change_password(
    password: str,
    current_user: LoggedIn,
    session: db.session,
    username: str | None = None,
):
    if username == None or username == current_user.username:
        user = current_user
    else:
        await admin_required(current_user)
        user = get_user(username, session=session)
    if not user:
        raise HTTPException(status_code=404, detail="User not found")
    user.hashed_password = get_password_hash(password)
    session.add(user)
    session.commit()
    return {"message": "Password changed successfully"}
@router.post("/change-permissions")
async def change_permissions(
    username: str,
    permissions: int,
    session: db.session,
    current_user: Admin,
):
    user = get_user(username, session=session)
    if not user:
        raise HTTPException(status_code=404, detail="User not found")
    user.permissions = permissions
    session.add(user)
    session.commit()
    return {"message": "Permissions changed successfully"}