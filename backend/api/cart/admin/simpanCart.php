<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include('../dbcart.php');

$data = $_POST;  // Ambil dari form HTML biasa (bukan JSON)

if ($data && isset($data['nama']) && isset($data['qty'])) {
  // Cek apakah ini UPDATE (ada ID) atau INSERT
  if (isset($data['id']) && $data['id'] != '') {
    // UPDATE
    $query = "UPDATE cart SET 
                nama_produk = :nama,
                qty = :qty,
                harga = :harga,
                berat = :berat,
                kota_tujuan = :kota_tujuan,
                ekspedisi = :ekspedisi,
                gambar = :gambar,
                total_harga = :total_harga
              WHERE id = :id";
  } else {
    // INSERT
    $query = "INSERT INTO cart (produk_id, nama_produk, qty, harga, berat, kota_tujuan, ekspedisi, gambar, total_harga)
              VALUES (:produk_id, :nama, :qty, :harga, :berat, :kota_tujuan, :ekspedisi, :gambar, :total_harga)";
  }

  $total_harga = $data['qty'] * $data['harga'];

  $stmt = $pdo->prepare($query);

  $params = [
    ':nama' => $data['nama'],
    ':qty' => $data['qty'],
    ':harga' => $data['harga'],
    ':berat' => $data['berat'],
    ':kota_tujuan' => $data['kota_tujuan'],
    ':ekspedisi' => $data['ekspedisi'],
    ':gambar' => $data['gambar'],
    ':total_harga' => $total_harga,
  ];

  // Tambah ID jika update
  if (isset($data['id']) && $data['id'] != '') {
    $params[':id'] = $data['id'];
  } else {
    $params[':produk_id'] = $data['produk_id'];
  }

  $stmt->execute($params);

  echo json_encode(["success" => true, "message" => "Cart berhasil disimpan"]);
} else {
  echo json_encode(["success" => false, "message" => "Data tidak valid."]);
}
