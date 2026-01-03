CREATE TABLE klanten (
  id INT AUTO_INCREMENT PRIMARY KEY,
  naam VARCHAR(255) NOT NULL,
  merk VARCHAR(255) NOT NULL,
  model VARCHAR(255) NOT NULL,
  nummerbord VARCHAR(20) NOT NULL,
  email VARCHAR(255),
  telefoon VARCHAR(50),
  wachtwoord VARCHAR(255) NOT NULL,
  laatste_bezoek DATE DEFAULT NULL,
  volgende_afspraak DATETIME DEFAULT NULL
);
