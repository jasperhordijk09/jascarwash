CREATE TABLE tijdvakken (
  id INT AUTO_INCREMENT PRIMARY KEY,
  starttijd TIME NOT NULL,
  eindtijd TIME NOT NULL,
  beschikbaar BOOLEAN DEFAULT TRUE
);
