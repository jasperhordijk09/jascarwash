from sqlmodel import SQLModel, Field, Relationship
from datetime import datetime, timezone
from typing import List, Optional
from lib import sqlFactories
from log import logger



class order(SQLModel, table=True):
    __tablename__ = "orders"  # pyright: ignore[reportAssignmentType]

    id: str = Field(default_factory=sqlFactories.generate_uuid, primary_key=True, unique=True)
    date: datetime = Field(nullable=False)
    category: str = Field(nullable=False, regex=r"^(optiea|optieb|optiec|optied|)$")
    description: str = Field(nullable=False)
    price: float = Field(nullable=False)
    notes: Optional[str] = None
    created_at: datetime = Field(default_factory=lambda: datetime.now(timezone.utc))
class User(SQLModel, table=True):
    __tablename__ = "users"  # pyright: ignore[reportAssignmentType]

    id: str = Field(default_factory=sqlFactories.generate_uuid, primary_key=True, unique=True)
    username: str = Field(index=True, nullable=False, unique=True)
    full_name: Optional[str] = None
    email: Optional[str] = None
    hashed_password: str = Field(nullable=False)
    disabled: bool = Field(default=False)
    created_at: datetime = Field(default_factory=lambda: datetime.now(timezone.utc))
    permissions: int = Field(default=0)