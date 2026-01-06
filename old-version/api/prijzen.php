<?php
require 'session-check.php';
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM prijzen WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(["status" => "OK", "prijs" => $stmt->fetch(PDO::FETCH_ASSOC)]);
        exit;
    }

    $stmt = $pdo->query("SELECT * FROM prijzen ORDER BY prijs ASC");
    echo json_encode(["status" => "OK", "prijzen" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
