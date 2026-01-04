<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $naam = $_POST['naam'] ?? '';
    $merk = $_POST['merk'] ?? '';
    $model = $_POST['model'] ?? '';
    $nummerbord = $_POST['nummerbord'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefoon = $_POST['telefoon'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';

    if (!$naam || !$merk || !$model || !$nummerbord || !$email || !$wachtwoord) {
        echo json_encode(["status" => "ERROR", "message" => "Niet alle velden zijn ingevuld"]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM klanten WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(["status" => "ERROR", "message" => "Email bestaat al"]);
        exit;
    }

    $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("
        INSERT INTO klanten (naam, merk, model, nummerbord, email, telefoon, wachtwoord)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$naam, $merk, $model, $nummerbord, $email, $telefoon, $hash]);

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
