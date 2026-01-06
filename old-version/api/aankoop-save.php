<?php
require 'session-check.php';
requireAdmin();
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $datum = $_POST['datum'] ?? null;
    $categorie = $_POST['categorie'] ?? '';
    $omschrijving = $_POST['omschrijving'] ?? '';
    $bedrag = $_POST['bedrag'] ?? 0;
    $opmerking = $_POST['opmerking'] ?? '';

    if (!$datum || !$categorie || !$bedrag) {
        echo json_encode(["status" => "ERROR", "message" => "Ontbrekende gegevens"]);
        exit;
    }

    $stmt = $pdo->prepare("
      INSERT INTO aankopen (datum, categorie, omschrijving, bedrag, opmerking)
      VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$datum, $categorie, $omschrijving, $bedrag, $opmerking]);

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
