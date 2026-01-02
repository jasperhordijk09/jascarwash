<?php
require 'session-check.php';

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

$login = $_POST['login'] ?? '';
$wachtwoord = $_POST['wachtwoord'] ?? '';

$stmt = $pdo->prepare("
  SELECT * FROM klanten 
  WHERE email = ? OR nummerbord = ?
");
$stmt->execute([$login, $login]);
$klant = $stmt->fetch(PDO::FETCH_ASSOC);

if ($klant && password_verify($wachtwoord, $klant['wachtwoord'])) {
  $_SESSION['klant_id'] = $klant['id'];
  echo "OK";
} else {
  echo "Onjuiste gegevens";
}
