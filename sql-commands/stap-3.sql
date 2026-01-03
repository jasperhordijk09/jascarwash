CREATE TABLE afspraken (
  id INT AUTO_INCREMENT PRIMARY KEY,
  klant_id INT NOT NULL,
  tijdvak_id INT NOT NULL,
  datum DATE NOT NULL,
  aangemaakt_op TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (klant_id) REFERENCES klanten(id),
  FOREIGN KEY (tijdvak_id) REFERENCES tijdvakken(id)
);
