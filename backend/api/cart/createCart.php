<?php

// 1. CORS & header
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Hanya menerima metode POST"
    ]);
    exit;
}

// 2. Include koneksi database
include __DIR__ . '/dbCart.php';

// 3. Debugging (optional)
$raw = trim(file_get_contents("php://input"));
file_put_contents('debug_log.txt', "RAW:\n" . $raw);
 // Debug log (tidak mempengaruhi pemrosesan)

$data = json_decode($raw, true);
if (!$data || json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        "success" => false,
        "message" => "Data JSON tidak valid",
        "json_error" => json_last_error_msg(), // ini akan bantu debug
        "raw" => $raw
    ]);
    exit;
}


// 5. Validasi field wajib
$requiredFields = ['produk_id', 'nama_produk', 'berat', 'harga', 'qty'];
foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        echo json_encode([
            "success" => false,
            "message" => "Data tidak lengkap: field $field hilang"
        ]);
        exit;
    }
}

// 6. Ambil data dari input
$produk_id = $data['produk_id'];
$nama_produk = $data['nama_produk'];
$berat = (int)$data['berat'];
$harga = (int)$data['harga'];
$qty = (int)$data['qty'];
$kota_tujuan = $data['kota_tujuan'] ?? null;
$ekspedisi = $data['ekspedisi'] ?? null;
$gambar = $data['gambar'] ?? null;

// 7. Hitung total harga
$total_harga = $harga * $qty;

// 8. Simpan ke database
try {
    $stmt = $pdo->prepare("
        INSERT INTO cart 
        (produk_id, nama_produk, berat, harga, qty, kota_tujuan, ekspedisi, gambar, total_harga)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $produk_id, $nama_produk, $berat, $harga, $qty, $kota_tujuan, $ekspedisi, $gambar, $total_harga
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Produk berhasil ditambahkan ke keranjang"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Gagal menyimpan ke database",
        "error" => $e->getMessage(), // Ini akan tampilkan error SQL asli
    ]);
}

