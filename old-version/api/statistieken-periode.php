<?php
require 'session-check.php';
requireAdmin();
header('Content-Type: application/json');

$van = $_GET['van'] ?? null;
$tot = $_GET['tot'] ?? null;

if (!$van || !$tot) {
    echo json_encode(["status" => "ERROR", "message" => "Geen periode opgegeven"]);
    exit;
}

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root');

    // Omzet + totale duur + aantal afspraken
    $stmt = $pdo->prepare("
      SELECT 
        COALESCE(SUM(totale_prijs), 0) AS omzet,
        COALESCE(SUM(duur_minuten), 0) AS totaal_duur,
        COUNT(*) AS aantal
      FROM afspraken
      WHERE datum BETWEEN ? AND ?
        AND status IN ('geweest', 'bezig', 'gepland')
    ");
    $stmt->execute([$van, $tot]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $omzet = (float)$row['omzet'];
    $totaal_duur = (int)$row['totaal_duur'];
    $aantal = (int)$row['aantal'];

    // Kosten
    $stmt = $pdo->prepare("
      SELECT COALESCE(SUM(bedrag), 0) AS kosten
      FROM aankopen
      WHERE datum BETWEEN ? AND ?
    ");
    $stmt->execute([$van, $tot]);
    $kosten = (float)$stmt->fetchColumn();

    // Berekeningen
    $winst = $omzet - $kosten;
    $gewerkte_uren = $totaal_duur > 0 ? round($totaal_duur / 60, 2) : 0;
    $inkomen_per_uur = $gewerkte_uren > 0 ? round($winst / $gewerkte_uren, 2) : 0;
    $gemiddelde_duur = $aantal > 0 ? round($totaal_duur / $aantal, 2) : 0;

    echo json_encode([
        "status" => "OK",
        "statistieken" => [
            "omzet" => $omzet,
            "kosten" => $kosten,
            "winst" => $winst,
            "gewerkte_uren" => $gewerkte_uren,
            "inkomen_per_uur" => $inkomen_per_uur,
            "gemiddelde_duur" => $gemiddelde_duur
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
}
