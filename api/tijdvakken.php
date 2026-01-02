<?php
require 'session-check.php';
requireCustomer();

header('Content-Type: application/json');

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

$stmt = $pdo->query("SELECT * FROM tijdvakken WHERE beschikbaar = 1");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
