<?php
require 'session-check.php';
requireAdmin();
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$duur_minuten = $_POST['duur_minuten'] ?? null;

if (!$id) {
    echo json_encode(["status" => "ERROR", "message" => "Geen afspraak ID"]);
    exit;
}

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');
    $pdo->beginTransaction();

    // Afspraak ophalen
    $stmt = $pdo->prepare("SELECT * FROM afspraken WHERE id = ?");
    $stmt->execute([$id]);
    $afspraak = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$afspraak) {
        echo json_encode(["status" => "ERROR", "message" => "Afspraak niet gevonden"]);
        exit;
    }

    // Afspraak bijwerken
    $stmt = $pdo->prepare("
        UPDATE afspraken 
        SET status = 'geweest', duur_minuten = ? 
        WHERE id = ?
    ");
    $stmt->execute([$duur_minuten, $id]);

    // Klant laatste bezoek updaten
    $stmt = $pdo->prepare("UPDATE klanten SET laatste_bezoek = ? WHERE id = ?");
    $stmt->execute([$afspraak['datum'], $afspraak['klant_id']]);

    $pdo->commit();

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
