<?php
require 'session-check.php';
requireAdmin();

$pdo = new PDO('mysql:host=mysql;dbname=testdb', 'root', 'root');

header("Content-Type: application/json");

// Toggle beschikbaarheid
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $pdo->query("UPDATE tijdvak_beschikbaarheid 
                     SET beschikbaar = NOT beschikbaar 
                     WHERE id = $id");
        echo json_encode(["status" => "OK"]);
        exit;
    }
}

// Ophalen per tijdvak
$rows = $pdo->query("
    SELECT tb.id, tb.tijdvak_id, tb.datum, tb.beschikbaar,
           t.starttijd, t.eindtijd
    FROM tijdvak_beschikbaarheid tb
    JOIN tijdvakken t ON tb.tijdvak_id = t.id
    ORDER BY tb.datum ASC, t.starttijd ASC
")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);
