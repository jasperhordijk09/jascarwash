<?php
require 'session-check.php';
requireAdmin();

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

$datum = $_POST['datum'] ?? null;
$tijdvak_id = $_POST['tijdvak_id'] ?? null;

if (!$datum || !$tijdvak_id) {
    echo "Datum en tijdvak verplicht.";
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO tijdvak_beschikbaarheid (tijdvak_id, datum, beschikbaar)
    VALUES (?, ?, 1)
");
$stmt->execute([$tijdvak_id, $datum]);

echo "OK";
