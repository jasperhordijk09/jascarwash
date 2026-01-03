CREATE TABLE tijdvak_beschikbaarheid (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tijdvak_id INT NOT NULL,
  datum DATE NOT NULL,
  beschikbaar BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (tijdvak_id) REFERENCES tijdvakken(id)
);