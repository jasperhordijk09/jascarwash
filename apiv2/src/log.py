import logging


logger: logging.Logger = logging.getLogger("uvicorn.error")
logger.setLevel(logging.DEBUG)
