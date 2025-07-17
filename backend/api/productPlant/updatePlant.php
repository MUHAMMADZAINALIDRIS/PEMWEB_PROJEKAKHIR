<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan"]);
    exit();
}

// Ambil body JSON
$data = json_decode(file_get_contents("php://input"));

if (
    empty($data->id) || empty($data->namaP) || empty($data->deskripsiP) ||
    empty($data->kategoriP) || empty($data->beratP) || empty($data->hargaP)
) {
    http_response_code(400);
    echo json_encode(["message" => "Data tidak lengkap"]);
    exit();
}

$conn = new mysqli("localhost", "root", "", "dbkita");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Koneksi database gagal"]);
    exit();
}

$query = "UPDATE productPlant SET namaP=?, deskripsiP=?, kategoriP=?, beratP=?, hargaP=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param(
    "sssddi",
    $data->namaP,
    $data->deskripsiP,
    $data->kategoriP,
    $data->beratP,
    $data->hargaP,
    $data->id
);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["message" => "Produk berhasil diupdate"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Gagal update"]);
}

$stmt->close();
$conn->close();
