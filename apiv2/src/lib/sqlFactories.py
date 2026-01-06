import uuid6


def generate_uuid() -> str:
    """Generate a UUID similar to SQLite's random blob-based format."""
    return str(uuid6.uuid7())
