<?php
require 'session-check.php';
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $email = $_POST['email'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM klanten WHERE email = ?");
    $stmt->execute([$email]);
    $klant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$klant || !password_verify($wachtwoord, $klant['wachtwoord'])) {
        echo json_encode(["status" => "ERROR", "message" => "Ongeldige inloggegevens"]);
        exit;
    }

    $_SESSION['klant_id'] = $klant['id'];

    echo json_encode(["status" => "OK"]);
} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
