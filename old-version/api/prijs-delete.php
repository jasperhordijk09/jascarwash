<?php
require 'session-check.php';
requireAdmin();
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $id = $_POST['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM prijzen WHERE id = ?");
        $stmt->execute([$id]);
    }

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
