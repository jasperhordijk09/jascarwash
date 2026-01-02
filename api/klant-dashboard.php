<?php
require 'session-check.php';
requireCustomer();

header('Content-Type: application/json');

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

$klant_id = $_SESSION['klant_id'];

$stmt = $pdo->prepare("SELECT * FROM klanten WHERE id = ?");
$stmt->execute([$klant_id]);
$klant = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare("
  SELECT a.datum, t.starttijd, t.eindtijd
  FROM afspraken a
  JOIN tijdvakken t ON a.tijdvak_id = t.id
  WHERE klant_id = ?
  ORDER BY datum DESC
");
$stmt2->execute([$klant_id]);
$afspraken = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
  "klant" => $klant,
  "afspraken" => $afspraken
]);
