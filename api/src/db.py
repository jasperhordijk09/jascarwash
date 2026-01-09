import os
from fastapi import Depends
from alembic import command
from typing import Annotated, Generator
from sqlalchemy import Engine
from alembic import command, config
from contextlib import contextmanager
from sqlmodel import SQLModel, Session, create_engine
from log import logger


DB_PATH: str = f"mysql+pymysql://root:root@mysql:3306/jascarwash"
if os.getenv("DEVMODE") == "true":
    logger.warning("Using in memory sqlite")
    engine: Engine = create_engine("sqlite://", connect_args={"check_same_thread": False})
else:
    logger.info("Using MySQL")
    engine: Engine = create_engine(DB_PATH)


def init():
    logger.info("Initializing database")
    SQLModel.metadata.create_all(engine)


@contextmanager
def get_session() -> Generator[Session, None, None]:
    with Session(engine) as session:
        yield session


def get_dep_session() -> Generator[Session, None, None]:
    with get_session() as session:
        yield session


session = Annotated[Session, Depends(get_dep_session)]
