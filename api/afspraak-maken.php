<?php
require 'session-check.php';
requireCustomer();

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

$klant_id = $_SESSION['klant_id'];
$datum = $_POST['datum'] ?? null;
$tijdvak_id = $_POST['tijdvak_id'] ?? null;

if (!$datum || !$tijdvak_id) {
  echo "Datum en tijdvak nodig.";
  exit;
}

$stmt = $pdo->prepare("
  INSERT INTO afspraken (klant_id, tijdvak_id, datum)
  VALUES (?, ?, ?)
");
if ($stmt->execute([$klant_id, $tijdvak_id, $datum])) {
  $stmt2 = $pdo->prepare("
    SELECT t.starttijd FROM tijdvakken t WHERE t.id = ?
  ");
  $stmt2->execute([$tijdvak_id]);
  $tijdvak = $stmt2->fetch(PDO::FETCH_ASSOC);
  $datetime = $datum . ' ' . $tijdvak['starttijd'];

  $upd = $pdo->prepare("UPDATE klanten SET volgende_afspraak = ? WHERE id = ?");
  $upd->execute([$datetime, $klant_id]);

  echo "OK";
} else {
  echo "Er ging iets mis.";
}
