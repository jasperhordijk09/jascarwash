<?php
require 'session-check.php';
requireAdmin();
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $stmt = $pdo->query("
      SELECT 
        a.id,
        a.datum,
        DAYNAME(a.datum) AS dagnaam,
        a.status,
        a.duur_minuten,
        a.totale_prijs,
        k.naam AS klant_naam,
        k.nummerbord,
        t.starttijd,
        t.eindtijd,
        p.naam AS pakket_naam
      FROM afspraken a
      JOIN klanten k ON a.klant_id = k.id
      JOIN tijdvakken t ON a.tijdvak_id = t.id
      JOIN prijzen p ON a.prijs_id = p.id
      ORDER BY a.datum