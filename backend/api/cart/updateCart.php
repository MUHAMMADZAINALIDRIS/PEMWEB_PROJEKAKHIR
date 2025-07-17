<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

include './dbCart.php';

// Ambil input JSON
$input = json_decode(file_get_contents("php://input"), true);
file_put_contents("debug_update.txt", print_r($input, true)); // Debug

// Validasi minimal
if (!isset($input['id'], $input['qty'])) {
    echo json_encode([
        "success" => false,
        "message" => "ID dan qty wajib dikirim"
    ]);
    exit();
}

// Ambil data input
$id = $input['id'];
$qty = (int)$input['qty'];
$nama = $input['nama'] ?? null;
$harga = $input['harga'] ?? 0;
$berat = $input['berat'] ?? 0;
$kota = $input['kota_tujuan'] ?? null;
$ekspedisi = $input['ekspedisi'] ?? null;
$gambar = $input['gambar'] ?? null;

// Hitung ulang total
$total_harga = $harga * $qty;

try {
    $updateStmt = $pdo->prepare("UPDATE cart SET 
        nama_produk = ?, 
        qty = ?, 
        harga = ?, 
        berat = ?, 
        kota_tujuan = ?, 
        ekspedisi = ?, 
        gambar = ?, 
        total_harga = ? 
    WHERE id = ?");

    $updateStmt->execute([
        $nama, $qty, $harga, $berat, $kota, $ekspedisi, $gambar, $total_harga, $id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Cart berhasil diperbarui",
        "total_harga_baru" => $total_harga
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Gagal update",
        "error" => $e->getMessage()
    ]);
}
