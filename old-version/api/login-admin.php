<?php
require 'session-check.php';
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE gebruikersnaam = ?");
    $stmt->execute([$gebruikersnaam]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin || $admin['wachtwoord'] !== $wachtwoord) {
        echo json_encode(["status" => "ERROR", "message" => "Ongeldige inloggegevens"]);
        exit;
    }

    $_SESSION['admin_id'] = $admin['id'];

    echo json_encode(["status" => "OK"]);
} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
