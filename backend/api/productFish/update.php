<?php
require 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Ambil data JSON
$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak valid."
    ]);
    exit;
}

// Ambil variabel dari data
$id = $data->id ?? null;
$nama = $data->nama ?? null;
$deskripsi = $data->deskripsi ?? null;
$kategori = $data->kategori ?? null;
$harga = $data->harga ?? null;
$gambar = $data->gambar ?? null;

// Validasi data minimum
if (!$id || !$nama || !$harga) {
    echo json_encode([
        "status" => "error",
        "message" => "Field 'id', 'nama', dan 'harga' wajib diisi."
    ]);
    exit;
}

// ✅ Ganti nama tabel di sini ↓↓↓↓↓
$query = "UPDATE productFish SET nama=?, deskripsi=?, kategori=?, harga=?, gambar=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssisi", $nama, $deskripsi, $kategori, $harga, $gambar, $id);

// Eksekusi dan kirim response
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Produk berhasil diupdate"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal mengupdate produk"]);
}
?>
