<?php
require 'session-check.php';
requireAdmin();

header('Content-Type: application/json');

try {
    $pdo = new PDO('mysql:host=mysql;dbname=testdb;charset=utf8mb4', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    /* -------------------------
       KLANTEN OPHALEN
    -------------------------- */
    $stmt = $pdo->prepare("SELECT * FROM klanten ORDER BY naam ASC");
    $stmt->execute();
    $klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* -------------------------
       AFSPRAKEN OPHALEN
    -------------------------- */
    $stmt = $pdo->prepare("
        SELECT 
            a.id,
            k.naam,
            a.datum,
            t.starttijd,
            t.eindtijd
        FROM afspraken a
        JOIN klanten k ON a.klant_id = k.id
        JOIN tijdvakken t ON a.tijdvak_id = t.id
        ORDER BY a.datum DESC, t.starttijd ASC
    ");
    $stmt->execute();
    $afspraken = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* -------------------------
       BEZOEKEN TELLEN
    -------------------------- */
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bezoek_log WHERE pagina = 'index'");
    $stmt->execute();
    $visits = $stmt->fetchColumn();

    /* -------------------------
       SYSTEEMINFO
    -------------------------- */
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

    /* -------------------------
       JSON TERUGSTUREN
    -------------------------- */
    echo json_encode([
        "status" => "OK",
        "klanten" => $klanten,
        "afspraken" => $afspraken,
        "sysinfo" => $sysinfo
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "ERROR",
        "message" => $e->getMessage()
    ]);
}
