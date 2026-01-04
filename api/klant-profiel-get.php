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

    $stmt = $pdo->prepare("SELECT * FROM klanten WHERE id = ?");
    $stmt->execute([$klant_id]);
    $klant = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "OK",
        "klant" => $klant
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "ERROR",
        "message" => $e->getMessage()
    ]);
}
