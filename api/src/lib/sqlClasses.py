from sqlmodel import SQLModel, Field, Relationship
from datetime import datetime, timezone
from typing import List, Optional
from lib import sqlFactories


class User(SQLModel, table=True):
    __tablename__ = "users"  # pyright: ignore[reportAssignmentType]

    id: str = Field(default_factory=sqlFactories.generate_uuid, primary_key=True, unique=True)
    username: str = Field(index=True, nullable=False, unique=True)
    full_name: Optional[str] = None
    email: Optional[str] = None
    phone: Optional[str] = None
    hashed_password: str = Field(nullable=False)
    disabled: bool = Field(default=False)
    created_at: datetime = Field(default_factory=lambda: datetime.now(timezone.utc))
    permissions: int = Field(default=0)

    cars: List["Car"] = Relationship(back_populates="owner")


class Car(SQLModel, table=True):
    __tablename__ = "cars"  # pyright: ignore[reportAssignmentType]

    id: str = Field(default_factory=sqlFactories.generate_uuid, primary_key=True, unique=True)
    license_plate: str = Field(index=True, nullable=False, unique=True)
    created_at: datetime = Field(default_factory=lambda: datetime.now(timezone.utc))
    notes: Optional[str] = None
    owner_id: Optional[str] = Field(default=None, foreign_key="users.id")

    owner: Optional[User] = Relationship(back_populates="cars")
