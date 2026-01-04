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

    $oud = $_POST['oud'] ?? '';
    $nieuw = $_POST['nieuw'] ?? '';
    $nieuw2 = $_POST['nieuw2'] ?? '';

    if (!$oud || !$nieuw || !$nieuw2) {
        echo json_encode(["status" => "ERROR", "message" => "Niet alle velden zijn ingevuld"]);
        exit;
    }

    if ($nieuw !== $nieuw2) {
        echo json_encode(["status" => "ERROR", "message" => "Nieuw wachtwoord komt niet overeen"]);
        exit;
    }

    // Huidig wachtwoord ophalen
    $stmt = $pdo->prepare("SELECT wachtwoord FROM klanten WHERE id = ?");
    $stmt->execute([$klant_id]);
    $klant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$klant || !password_verify($oud, $klant['wachtwoord'])) {
        echo json_encode(["status" => "ERROR", "message" => "Huidig wachtwoord is onjuist"]);
        exit;
    }

    // Nieuw wachtwoord opslaan
    $hash = password_hash($nieuw, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE klanten SET wachtwoord = ? WHERE id = ?");
    $stmt->execute([$hash, $klant_id]);

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "ERROR",
        "message" => $e->getMessage()
    ]);
}
