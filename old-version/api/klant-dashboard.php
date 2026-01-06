<?php
require 'session-check.php';
requireCustomer();
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $klant_id = $_SESSION['klant_id'];

    $stmt = $pdo->prepare("SELECT * FROM klanten WHERE id = ?");
    $stmt->execute([$klant_id]);
    $klant = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("
      SELECT 
        a.id,
        a.datum,
        DAYNAME(a.datum) AS dagnaam,
        a.status,
        a.totale_prijs,
        t.starttijd,
        t.eindtijd,
        p.naam AS pakket_naam
      FROM afspraken a
      JOIN tijdvakken t ON a.tijdvak_id = t.id
      JOIN prijzen p ON a.prijs_id = p.id
      WHERE a.klant_id = ?
        AND a.datum >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
      ORDER BY a.datum DESC, t.starttijd ASC
    ");
$stmt->execute([$klant_id]);

    $stmt->execute([$klant_id]);
    $afspraken = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT * FROM prijzen ORDER BY prijs ASC");
    $prijzen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "OK",
        "klant" => $klant,
        "afspraken" => $afspraken,
        "prijzen" => $prijzen
    ]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
