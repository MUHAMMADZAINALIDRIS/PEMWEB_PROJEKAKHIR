<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type");


// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Cek method valid
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan"]);
    exit();
}

// Koneksi DB
$conn = new mysqli("localhost", "root", "", "dbkita");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Koneksi database gagal"]);
    exit();
}

// Ambil data JSON dari input yang sesuai method
$input = null;
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents("php://input"));
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"));
}

if (empty($input->id)) {
    http_response_code(400);
    echo json_encode(["message" => "ID produk wajib ada"]);
    exit();
}

$query = "DELETE FROM productPlant WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $input->id);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["message" => "Produk berhasil dihapus"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Gagal menghapus produk"]);
}

$stmt->close();
$conn->close();
