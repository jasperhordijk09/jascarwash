<?php
require 'session-check.php';
requireCustomer();
header('Content-Type: application/json');

try {
    $pdo = new PDO(
        'mysql:host=mysql;dbname=testdb;charset=utf8mb4',
        'root',
        'root',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $klant_id = $_SESSION['klant_id'];
    $datum = $_POST['datum'] ?? null;
    $prijs_id = $_POST['prijs_id'] ?? null;
    $tijdvakken = $_POST['tijdvakken'] ?? [];

    if (!$datum || !$prijs_id || empty($tijdvakken)) {
        echo json_encode(["status" => "ERROR", "message" => "Niet alle velden zijn ingevuld"]);
        exit;
    }

    // ❗ Datum mag niet in het verleden liggen
    if ($datum < date('Y-m-d')) {
        echo json_encode([
            "status" => "ERROR",
            "message" => "Je kunt geen afspraak maken op een datum in het verleden."
        ]);
        exit;
    }

    // ❗ Check of de dag een werkdag is
    $dagnaam_eng = strtolower(date('l', strtotime($datum))); // monday
    $map = [
        "monday" => "maandag",
        "tuesday" => "dinsdag",
        "wednesday" => "woensdag",
        "thursday" => "donderdag",
        "friday" => "vrijdag",
        "saturday" => "zaterdag",
        "sunday" => "zondag"
    ];
    $dag_nl = $map[$dagnaam_eng];

    $stmt = $pdo->prepare("SELECT actief FROM werkdagen WHERE dag = ?");
    $stmt->execute([$dag_nl]);
    $werkdag = $stmt->fetchColumn();

    if (!$werkdag) {
        echo json_encode([
            "status" => "ERROR",
            "message" => "Op deze dag wordt er niet gewerkt."
        ]);
        exit;
    }

    // ❗ Check of klant al een afspraak heeft op die datum
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM afspraken WHERE klant_id = ? AND datum = ?");
    $stmt->execute([$klant_id, $datum]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode([
            "status" => "ERROR",
            "message" => "Je hebt al een afspraak op deze datum."
        ]);
        exit;
    }

    // ❗ Check of tijdvakken beschikbaar zijn
    foreach ($tijdvakken as $tv) {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM afspraken 
            WHERE datum = ? AND tijdvak_id = ?
        ");
        $stmt->execute([$datum, $tv]);

        if ($stmt->fetchColumn() > 0) {
            echo json_encode([
                "status" => "ERROR",
                "message" => "Een van de gekozen tijdvakken is al bezet."
            ]);
            exit;
        }
    }

    // ❗ Prijs ophalen
    $stmt = $pdo->prepare("SELECT prijs FROM prijzen WHERE id = ?");
    $stmt->execute([$prijs_id]);
    $prijs = $stmt->fetchColumn();

    if (!$prijs) {
        echo json_encode(["status" => "ERROR", "message" => "Ongeldig pakket"]);
        exit;
    }

    // ❗ Afspraak opslaan
    foreach ($tijdvakken as $tv) {
        $stmt = $pdo->prepare("
            INSERT INTO afspraken (klant_id, datum, tijdvak_id, prijs_id, totale_prijs, status)
            VALUES (?, ?, ?, ?, ?, 'gepland')
        ");
        $stmt->execute([$klant_id, $datum, $tv, $prijs_id, $prijs]);
    }

    echo json_encode(["status" => "OK"]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "ERROR",
        "message" => $e->getMessage()
    ]);
}
