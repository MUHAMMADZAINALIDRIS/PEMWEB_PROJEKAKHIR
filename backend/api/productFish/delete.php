<?php
require 'db.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


// Cegah error OPTIONS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents("php://input"));
$id = $data->id ?? null;

if (!$id) {
  echo json_encode(["status" => "error", "message" => "ID tidak ditemukan"]);
  exit;
}

$query = "DELETE FROM productfish WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "message" => "Produk berhasil dihapus"]);
} else {
  echo json_encode(["status" => "error", "message" => "Gagal menghapus produk"]);
}
?>

