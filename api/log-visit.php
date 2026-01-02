<?php
require 'session-check.php';

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

$ip = $_SERVER['REMOTE_ADDR'];
$page = $_GET['page'] ?? 'unknown';

$stmt = $pdo->prepare("INSERT INTO bezoek_log (ip, pagina) VALUES (?, ?)");
$stmt->execute([$ip, $page]);

echo "OK";
