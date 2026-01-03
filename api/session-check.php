<?php
session_start();

header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

function requireCustomer() {
    if (!isset($_SESSION['klant_id'])) {
        echo json_encode(["error" => "Niet ingelogd"]);
        exit;
    }
}

function requireAdmin() {
    if (!isset($_SESSION['admin_id'])) {
        echo json_encode(["error" => "Niet ingelogd als beheerder"]);
        exit;
    }
}
