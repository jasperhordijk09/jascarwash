FROM python:3.12-alpine
WORKDIR /code
RUN apk add --no-cache \
    build-base \
    mariadb-connector-c-dev \
    mariadb-dev \
    gcc \
    musl-dev \
    linux-headers \
    curl
RUN pip install --upgrade pip
COPY requirements.txt requirements.txt
RUN pip install -r requirements.txt --no-cache
COPY src /code/
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000", "--workers", "1", "--log-level", "info"]