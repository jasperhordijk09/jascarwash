<?php
require 'session-check.php';
requireCustomer();
header('Content-Type: application/json');

$klant_id = $_SESSION['klant_id'];
$afspraak_id = $_POST['afspraak_id'] ?? null;

if (!$afspraak_id) {
    echo json_encode(["status" => "ERROR", "message" => "Geen afspraak ID ontvangen"]);
    exit;
}

try {
    $pdo = new PDO(
        'mysql:host=mysql;dbname=testdb;charset=utf8mb4',
        'root',
        'root',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Controleer of de afspraak van deze klant is
    $stmt = $pdo->prepare("
        SELECT * FROM afspraken 
        WHERE id = ? AND klant_id = ?
    ");
    $stmt->execute([$afspraak_id, $klant_id]);
    $afspraak = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$afspraak) {
        echo json_encode(["status" => "ERROR", "message" => "Afspraak niet gevonden"]);
        exit;
    }

    // Alleen toekomstige afspraken mogen worden geannuleerd
    if ($afspraak['datum'] < date('Y-m-d')) {
        echo json_encode(["status" => "ERROR", "message" => "Je kunt geen afspraken uit het verleden annuleren"]);
        exit;
    }

    // Update status
    $stmt = $pdo->prepare("
        UPDATE afspraken 
        SET status = 'geannuleerd'
        WHERE id = ?
    ");
    $stmt->execute([$afspraak_id]);

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
