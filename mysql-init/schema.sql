-- DATABASE STRUCTUUR VOOR JAS CAR WASH
-- Compatibel met alle API-bestanden

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================
-- TABEL: klanten
-- ============================
DROP TABLE IF EXISTS klanten;
CREATE TABLE klanten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    merk VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    nummerbord VARCHAR(50) NOT NULL,
    email VARCHAR(255) UNIQUE,
    telefoon VARCHAR(50),
    wachtwoord VARCHAR(255) NOT NULL,
    laatste_bezoek DATE DEFAULT NULL,
    volgende_afspraak DATE DEFAULT NULL,
    aangemaakt_op TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================
-- TABEL: admins
-- ============================
DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gebruikersnaam VARCHAR(255) UNIQUE NOT NULL,
    wachtwoord VARCHAR(255) NOT NULL
);

-- Standaard admin
INSERT INTO admins (gebruikersnaam, wachtwoord)
VALUES ('admin', 'admin');

-- ============================
-- TABEL: prijzen (pakketten)
-- ============================
DROP TABLE IF EXISTS prijzen;
CREATE TABLE prijzen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    beschrijving TEXT,
    prijs DECIMAL(10,2) NOT NULL
);

-- ============================
-- TABEL: tijdvakken
-- ============================
DROP TABLE IF EXISTS tijdvakken;
CREATE TABLE tijdvakken (
    id INT AUTO_INCREMENT PRIMARY KEY,
    starttijd TIME NOT NULL,
    eindtijd TIME NOT NULL,
    beschikbaar TINYINT(1) DEFAULT 1
);

-- Voorbeeld tijdvakken (optioneel)
INSERT INTO tijdvakken (starttijd, eindtijd) VALUES
('09:00', '10:00'),
('10:00', '11:00'),
('11:00', '12:00'),
('12:00', '13:00'),
('13:00', '14:00'),
('14:00', '15:00'),
('15:00', '16:00');

-- ============================
-- TABEL: tijdvak_beschikbaarheid
-- ============================
DROP TABLE IF EXISTS tijdvak_beschikbaarheid;
CREATE TABLE tijdvak_beschikbaarheid (
    id INT AUTO_INCREMENT PRIMARY KEY,
    datum DATE NOT NULL,
    tijdvak_id INT NOT NULL,
    beschikbaar TINYINT(1) DEFAULT 1,
    FOREIGN KEY (tijdvak_id) REFERENCES tijdvakken(id) ON DELETE CASCADE
);

-- ============================
-- TABEL: afspraken
-- ============================
DROP TABLE IF EXISTS afspraken;
CREATE TABLE afspraken (
    id INT AUTO_INCREMENT PRIMARY KEY,
    klant_id INT NOT NULL,
    datum DATE NOT NULL,
    tijdvak_id INT NOT NULL,
    prijs_id INT NOT NULL,
    totale_prijs DECIMAL(10,2) NOT NULL,
    status ENUM('gepland','bezig','geweest','geannuleerd') DEFAULT 'gepland',
    duur_minuten INT DEFAULT NULL,
    aangemaakt_op TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (klant_id) REFERENCES klanten(id) ON DELETE CASCADE,
    FOREIGN KEY (tijdvak_id) REFERENCES tijdvakken(id),
    FOREIGN KEY (prijs_id) REFERENCES prijzen(id)
);

-- ============================
-- TABEL: afspraak_tijdvakken (meerdere tijdvakken per afspraak)
-- ============================
DROP TABLE IF EXISTS afspraak_tijdvakken;
CREATE TABLE afspraak_tijdvakken (
    id INT AUTO_INCREMENT PRIMARY KEY,
    afspraak_id INT NOT NULL,
    tijdvak_id INT NOT NULL,
    FOREIGN KEY (afspraak_id) REFERENCES afspraken(id) ON DELETE CASCADE,
    FOREIGN KEY (tijdvak_id) REFERENCES tijdvakken(id)
);

-- ============================
-- TABEL: aankopen (kosten)
-- ============================
DROP TABLE IF EXISTS aankopen;
CREATE TABLE aankopen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    datum DATE NOT NULL,
    categorie VARCHAR(255) NOT NULL,
    omschrijving VARCHAR(255),
    bedrag DECIMAL(10,2) NOT NULL,
    opmerking TEXT,
    aangemaakt_op TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================
-- TABEL: bezoek_log
-- ============================
DROP TABLE IF EXISTS bezoek_log;
CREATE TABLE bezoek_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pagina VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================
-- TABEL: werkdagen
-- ============================
DROP TABLE IF EXISTS werkdagen;
CREATE TABLE werkdagen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dag VARCHAR(20) NOT NULL,
    actief TINYINT(1) DEFAULT 0
);

-- Standaard: alleen zaterdag actief
INSERT INTO werkdagen (dag, actief) VALUES
('maandag', 0),
('dinsdag', 0),
('woensdag', 0),
('donderdag', 0),
('vrijdag', 0),
('zaterdag', 1),
('zondag', 0);

SET FOREIGN_KEY_CHECKS = 1;
