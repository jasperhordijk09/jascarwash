import jwt
import uvicorn
from contextlib import asynccontextmanager
from datetime import datetime, timezone, timedelta
from fastapi import FastAPI, Request, Response


import auth
import routes.route as route

import db
from log import logger



@asynccontextmanager
async def lifespan(app):
    db.init()        
    with db.get_session() as session:
        auth.initDb(session)
    yield


app = FastAPI(
    title="jascarwash API",
    description="API for jascarwash",
    root_path="/api",
    lifespan=lifespan,
)


@app.middleware("http")
async def refresh_jwt_middleware(request: Request, call_next):
    response: Response = await call_next(request)
    token = request.cookies.get("jascarwash_access_token")
    if not token:
        return response
    if (
        "set-cookie" in response.headers
        and "jascarwash_access_token" in response.headers["set-cookie"]
    ):
        return response
    try:
        payload = jwt.decode(token, auth.SECRET_KEY, algorithms=[auth.ALGORITHM])
        username = payload.get("sub")
        exp_timestamp = payload.get("exp")

        if not username or not exp_timestamp:
            return response

        # Only refresh if token is about to expire (e.g., less than 5 minutes remaining)
        expire_time = datetime.fromtimestamp(exp_timestamp, tz=timezone.utc)
        now = datetime.now(timezone.utc)
        if expire_time - now < timedelta(seconds=auth.ACCESS_TOKEN_EXPIRE_SECONDS / 2):
            new_token = auth.create_access_token({"sub": username})
            response.set_cookie(**auth.authCookie, value=new_token)

    except jwt.ExpiredSignatureError:
        response.delete_cookie(**auth.authCookie)
    except jwt.InvalidTokenError:
        pass

    return response


app.include_router(auth.router)
app.include_router(route.router)

if __name__ == "__main__":
    uvicorn.run(
        "main:app",  # module_name:app_instance
        # app,
        host="0.0.0.0",
        port=11472,
        reload=True,  # equivalent to --reload
        log_level="debug",  # equivalent to --log-level debug
    )
