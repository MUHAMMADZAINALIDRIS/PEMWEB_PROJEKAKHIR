<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include '../dbCart.php'; // atau sesuaikan path db.php

$input = json_decode(file_get_contents("php://input"), true);

$origin = $input['origin'] ?? null;
$destination = $input['destination'] ?? null;
$courier = $input['courier'] ?? null;

if (!$origin || !$destination || !$courier) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT ongkir_per_kg FROM ongkir WHERE origin = ? AND destination = ? AND courier = ?");
    $stmt->execute([$origin, $destination, $courier]);
    $ongkirData = $stmt->fetch();

    if ($ongkirData) {
        echo json_encode(["success" => true, "ongkir_per_kg" => (int)$ongkirData['ongkir_per_kg']]);
    } else {
        echo json_encode(["success" => false, "message" => "Data ongkir tidak ditemukan"]);
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Gagal mengambil data ongkir", "error" => $e->getMessage()]);
}
