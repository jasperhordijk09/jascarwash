<?php
require 'session-check.php';

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

$gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
$wachtwoord = $_POST['wachtwoord'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM admins WHERE gebruikersnaam = ?");
$stmt->execute([$gebruikersnaam]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

/*
 * Voor productie: password_hash + password_verify.
 * Nu simpel voor testen:
*/
if ($admin && $admin['wachtwoord'] === $wachtwoord) {
  $_SESSION['admin_id'] = $admin['id'];
  echo "OK";
} else {
  echo "Onjuiste admin gegevens";
}
