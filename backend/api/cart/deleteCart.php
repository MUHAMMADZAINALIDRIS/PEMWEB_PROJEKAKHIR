<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

include './dbCart.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode([
        "success" => false,
        "message" => "ID item wajib dikirim"
    ]);
    exit();
}

$id = $data['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode([
        "success" => true,
        "message" => "Item berhasil dihapus"
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Gagal menghapus item",
        "error" => $e->getMessage()
    ]);
}
