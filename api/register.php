<?php
require 'session-check.php';

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

$naam = $_POST['naam'] ?? '';
$merk = $_POST['merk'] ?? '';
$model = $_POST['model'] ?? '';
$nummerbord = $_POST['nummerbord'] ?? '';
$email = $_POST['email'] ?? null;
$telefoon = $_POST['telefoon'] ?? null;
$wachtwoord_plain = $_POST['wachtwoord'] ?? '';

if (!$naam || !$merk || !$model || !$nummerbord || !$wachtwoord_plain) {
  echo "Vul alle verplichte velden in.";
  exit;
}

$wachtwoord = password_hash($wachtwoord_plain, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
  INSERT INTO klanten (naam, merk, model, nummerbord, email, telefoon, wachtwoord)
  VALUES (?, ?, ?, ?, ?, ?, ?)
");

if ($stmt->execute([$naam, $merk, $model, $nummerbord, $email, $telefoon, $wachtwoord])) {
  echo "OK";
} else {
  echo "Er ging iets mis.";
}
