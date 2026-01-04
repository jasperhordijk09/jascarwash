<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

function requireCustomer() {
    if (!isset($_SESSION['klant_id'])) {
        echo json_encode(["status" => "ERROR", "message" => "Niet ingelogd"]);
        exit;
    }
}

function requireAdmin() {
    if (!isset($_SESSION['admin_id'])) {
        echo json_encode(["status" => "ERROR", "message" => "Niet ingelogd als beheerder"]);
        exit;
    }
}
