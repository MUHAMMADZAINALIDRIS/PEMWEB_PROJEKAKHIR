<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Cek apakah file dikirim
if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
    $target_dir = __DIR__ . "/../upload/"; // Pastikan ini menuju folder upload yang benar
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true); // Buat folder jika belum ada
    }

    $filename = time() . "_" . basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $filename;

    // Pindahkan file
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo json_encode(["status" => "success", "filename" => $filename]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal memindahkan file."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "File tidak ditemukan atau error saat upload."]);
}
