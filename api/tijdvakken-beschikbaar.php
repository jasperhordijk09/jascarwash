<?php
require 'session-check.php';
header('Content-Type: application/json');

$datum = $_GET['datum'] ?? null;
if (!$datum) {
    echo json_encode(["status" => "ERROR", "message" => "Geen datum opgegeven"]);
    exit;
}

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $stmt = $pdo->prepare("
      SELECT t.id, t.starttijd, t.eindtijd
      FROM tijdvakken t
      LEFT JOIN tijdvak_beschikbaarheid b
        ON b.tijdvak_id = t.id AND b.datum = ?
      WHERE IFNULL(b.beschikbaar, t.beschikbaar) = 1
      ORDER BY t.starttijd
    ");
    $stmt->execute([$datum]);

    echo json_encode(["status" => "OK", "tijdvakken" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
