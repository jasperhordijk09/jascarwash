<?php
require 'session-check.php';
requireCustomer();
header('Content-Type: application/json');

try {
    $pdo = new PDO(
        'mysql:host=mysql;dbname=testdb;charset=utf8mb4',
        'root',
        'root',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $klant_id = $_SESSION['klant_id'];

    $naam = $_POST['naam'] ?? '';
    $merk = $_POST['merk'] ?? '';
    $model = $_POST['model'] ?? '';
    $nummerbord = $_POST['nummerbord'] ?? '';
    $telefoon = $_POST['telefoon'] ?? '';

    if (!$naam || !$merk || !$model || !$nummerbord) {
        echo json_encode(["status" => "ERROR", "message" => "Niet alle velden zijn ingevuld"]);
        exit;
    }

    $stmt = $pdo->prepare("
        UPDATE klanten
        SET naam = ?, merk = ?, model = ?, nummerbord = ?, telefoon = ?
        WHERE id = ?
    ");
    $stmt->execute([$naam, $merk, $model, $nummerbord, $telefoon, $klant_id]);

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "ERROR",
        "message" => $e->getMessage()
    ]);
}
