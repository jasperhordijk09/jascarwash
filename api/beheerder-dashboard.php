<?php
require 'session-check.php';
requireAdmin();
header('Content-Type: application/json');

try {
    // Database connectie
    $pdo = new PDO(
        'mysql:host=mysql;dbname=testdb;charset=utf8mb4',
        'root',
        'root',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Afspraken ophalen
    $stmt = $pdo->query("
      SELECT 
        a.id,
        a.datum,
        DAYNAME(a.datum) AS dagnaam,
        a.status,
        a.duur_minuten,
        a.totale_prijs,
        k.naam AS klant_naam,
        k.nummerbord,
        t.starttijd,
        t.eindtijd,
        p.naam AS pakket_naam
      FROM afspraken a
      JOIN klanten k ON a.klant_id = k.id
      JOIN tijdvakken t ON a.tijdvak_id = t.id
      JOIN prijzen p ON a.prijs_id = p.id
      ORDER BY a.datum DESC, t.starttijd ASC
    ");
    $afspraken = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prijzen ophalen
    $stmt = $pdo->query("SELECT * FROM prijzen ORDER BY prijs ASC");
    $prijzen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Aankopen ophalen
    $stmt = $pdo->query("SELECT * FROM aankopen ORDER BY datum DESC, id DESC LIMIT 50");
    $aankopen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Bezoekstatistieken
    $stmt = $pdo->query("SELECT COUNT(*) FROM bezoek_log WHERE pagina = 'index'");
    $visits = $stmt->fetchColumn();

    // Systeeminformatie
    $uptime = @shell_exec("uptime") ?: "Onbekend";
    $load = @sys_getloadavg() ?: [0,0,0];
    $disk_total = @round(disk_total_space("/") / 1024 / 1024, 2);
    $disk_used = @round((disk_total_space("/") - disk_free_space("/")) / 1024 / 1024, 2);

    $sysinfo = [
        "uptime" => trim($uptime),
        "cpu" => implode(", ", $load),
        "disk_total" => $disk_total,
        "disk_used" => $disk_used,
        "visits" => $visits
    ];

    // JSON output
    echo json_encode([
        "status" => "OK",
        "afspraken" => $afspraken,
        "prijzen" => $prijzen,
        "aankopen" => $aankopen,
        "sysinfo" => $sysinfo
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "ERROR",
        "message" => $e->getMessage()
    ]);
}
