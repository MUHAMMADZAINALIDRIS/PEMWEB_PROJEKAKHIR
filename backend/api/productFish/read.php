<?php
require 'db.php';
header("Access-Control-Allow-Origin: *"); // <- tambahkan ini agar tidak ditolak oleh CORS
header("Content-Type: application/json");

include_once 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Ambil hanya 1 produk berdasarkan ID
    $query = "SELECT * FROM productfish WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["message" => "Produk tidak ditemukan"]);
    }
} else {
    // Jika tidak ada ID, tampilkan semua
    $query = "SELECT * FROM productfish";
    $result = $conn->query($query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}
?>
