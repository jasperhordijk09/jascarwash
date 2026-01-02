<?php
require 'session-check.php';
requireAdmin();

header('Content-Type: application/json');

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

$klanten = $pdo->query("SELECT * FROM klanten ORDER BY naam ASC")->fetchAll(PDO::FETCH_ASSOC);

$afspraken = $pdo->query("
  SELECT k.naam, a.datum, t.starttijd, t.eindtijd
  FROM afspraken a
  JOIN klanten k ON a.klant_id = k.id
  JOIN tijdvakken t ON a.tijdvak_id = t.id
  ORDER BY a.datum DESC
")->fetchAll(PDO::FETCH_ASSOC);

$visits = $pdo->query("SELECT COUNT(*) FROM bezoek_log WHERE pagina = 'index'")->fetchColumn();

$uptime = shell_exec("uptime");
$load = sys_getloadavg();
$disk_total = round(disk_total_space("/") / 1024 / 1024, 2);
$disk_used = round((disk_total_space("/") - disk_free_space("/")) / 1024 / 1024, 2);

$sysinfo = [
  "uptime" => $uptime,
  "cpu" => implode(", ", $load),
  "disk_total" => $disk_total,
  "disk_used" => $disk_used,
  "visits" => $visits
];

echo json_encode([
  "klanten" => $klanten,
  "afspraken" => $afspraken,
  "sysinfo" => $sysinfo
]);
