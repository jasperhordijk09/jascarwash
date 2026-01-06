<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO(
        'mysql:host=mysql;dbname=testdb;charset=utf8mb4',
        'root',
        'root',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $naam = $_POST['naam'] ?? '';
    $telefoon = $_POST['telefoon'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';
    $kenteken = $_POST['kenteken'] ?? '';
    $merk = $_POST['merk'] ?? '';
    $model = $_POST['model'] ?? '';

    if (!$naam || !$wachtwoord || !$kenteken || !$merk || !$model) {
        echo json_encode(["status" => "ERROR", "message" => "Niet alle velden zijn ingevuld"]);
        exit;
    }

    $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO klanten (naam, telefoon, wachtwoord, nummerbord, merk, model)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$naam, $telefoon, $hash, $kenteken, $merk, $model]);

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
