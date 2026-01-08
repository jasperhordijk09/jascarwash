from typing import TypeVar, cast
from sqlalchemy.orm.attributes import InstrumentedAttribute

T = TypeVar("T")

def col(attr: T) -> InstrumentedAttribute[T]:
    return cast(InstrumentedAttribute[T], attr)
