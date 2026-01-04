<?php
require 'session-check.php';
requireCustomer();
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');
    $pdo->beginTransaction();

    $klant_id = $_SESSION['klant_id'];
    $datum = $_POST['datum'] ?? null;
    $prijs_id = $_POST['prijs_id'] ?? null;
    $tijdvakken = $_POST['tijdvakken'] ?? [];

    if (!$datum || !$prijs_id || empty($tijdvakken)) {
        echo json_encode(["status" => "ERROR", "message" => "Ontbrekende gegevens"]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM prijzen WHERE id = ?");
    $stmt->execute([$prijs_id]);
    $prijs = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prijs) {
        echo json_encode(["status" => "ERROR", "message" => "Ongeldig pakket"]);
        exit;
    }

    $totale_prijs = $prijs['prijs'];
    $hoofdtijdvak_id = (int)$tijdvakken[0];

    $stmt = $pdo->prepare("
      INSERT INTO afspraken (klant_id, datum, tijdvak_id, prijs_id, totale_prijs)
      VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$klant_id, $datum, $hoofdtijdvak_id, $prijs_id, $totale_prijs]);
    $afspraak_id = $pdo->lastInsertId();

    $stmtAT = $pdo->prepare("INSERT INTO afspraak_tijdvakken (afspraak_id, tijdvak_id) VALUES (?, ?)");
    foreach ($tijdvakken as $tv_id) {
        $stmtAT->execute([$afspraak_id, $tv_id]);
    }

    $stmt = $pdo->prepare("UPDATE klanten SET volgende_afspraak = ? WHERE id = ?");
    $stmt->execute([$datum, $klant_id]);

    $pdo->commit();

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
