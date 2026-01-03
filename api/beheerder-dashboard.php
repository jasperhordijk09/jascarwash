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
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    /* -------------------------
       KLANTEN OPHALEN
    -------------------------- */
    $klantenQuery = $pdo->prepare("
        SELECT 
            id,
            naam,
            merk,
            model,
            nummerbord,
            email,
            telefoon,
            laatste_bezoek,
            volgende_afspraak
        FROM klanten
        ORDER BY naam ASC
    ");
    $klantenQuery->execute();
    $klanten = $klantenQuery->fetchAll(PDO::FETCH_ASSOC);

    /* -------------------------
       AFSPRAKEN OPHALEN
    -------------------------- */
    $afsprakenQuery = $pdo->prepare("
        SELECT 
            a.id,
            k.naam,
            a.datum,
            t.starttijd,
            t.eindtijd
        FROM afspraken a
        INNER JOIN klanten k ON a.klant_id = k.id
        INNER JOIN tijdvakken t ON a.tijdvak_id = t.id
        ORDER BY a.datum DESC, t.starttijd ASC
    ");
    $afsprakenQuery->execute();
    $afspraken = $afsprakenQuery->fetchAll(PDO::FETCH_ASSOC);

    /* -------------------------
       BEZOEKEN TELLEN
    -------------------------- */
    $visitsQuery = $pdo->prepare("
        SELECT COUNT(*) 
        FROM bezoek_log 
        WHERE pagina = 'index'
    ");
    $visitsQuery->execute();
    $visits = $visitsQuery->fetchColumn();

    /* -------------------------
       SYSTEEMINFO
    -------------------------- */
    $uptime = @shell_exec("uptime") ?: "Onbekend";
    $load = @sys_getloadavg() ?: [0, 0, 0];

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
