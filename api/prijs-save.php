<?php
require 'session-check.php';
requireAdmin();
header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    $id = $_POST['id'] ?? null;
    $naam = $_POST['naam'] ?? '';
    $beschrijving = $_POST['beschrijving'] ?? '';
    $prijs = $_POST['prijs'] ?? 0;

    if ($id) {
        $stmt = $pdo->prepare("UPDATE prijzen SET naam = ?, beschrijving = ?, prijs = ? WHERE id = ?");
        $stmt->execute([$naam, $beschrijving, $prijs, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO prijzen (naam, beschrijving, prijs) VALUES (?, ?, ?)");
        $stmt->execute([$naam, $beschrijving, $prijs]);
    }

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
