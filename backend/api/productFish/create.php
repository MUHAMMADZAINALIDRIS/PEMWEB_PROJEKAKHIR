<?php
require 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *"); // Ini penting!
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Sesuaikan metode
header("Content-Type: application/json");


// Ambil JSON dari body request
$data = json_decode(file_get_contents("php://input"));

// Validasi JSON
if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak valid. Pastikan dikirim dalam format JSON."
    ]);
    exit;
}

// Ambil dan validasi data
$nama = $data->nama ?? null;
$deskripsi = $data->deskripsi ?? null;
$kategori = $data->kategori ?? null;
$harga = $data->harga ?? null;
$gambar = $data->gambar ?? null;

if (!$nama || !$harga) {
    echo json_encode([
        "status" => "error",
        "message" => "Field 'nama' dan 'harga' wajib diisi."
    ]);
    exit;
}

// Siapkan query (berat di-set langsung 1, tidak dari $data)
$query = "INSERT INTO productFish (nama, deskripsi, kategori, berat, harga, gambar) 
          VALUES (?, ?, ?, 1, ?, ?)";
$stmt = $conn->prepare($query);

// Bind parameter sesuai urutan: nama, deskripsi, kategori, harga, gambar
$stmt->bind_param("sssis", $nama, $deskripsi, $kategori, $harga, $gambar);

// Eksekusi dan respon
if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Produk berhasil ditambahkan"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menambahkan produk"
    ]);
}
?>