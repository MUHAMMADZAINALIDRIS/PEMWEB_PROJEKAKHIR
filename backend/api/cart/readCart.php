<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include './dbCart.php'; // Pastikan path benar

try {
  // Ambil parameter ID dari URL jika ada
  $id = isset($_GET['id']) ? intval($_GET['id']) : null;

  if ($id) {
    // Ambil data tertentu berdasarkan ID
    $stmt = $pdo->prepare("
      SELECT 
        cart.id,
        cart.qty,
        cart.kota_tujuan,
        cart.ekspedisi,
        productFish.nama,
        productFish.gambar,
        productFish.harga,
        productFish.berat
      FROM cart
      JOIN productFish ON cart.produk_id = productFish.id
      WHERE cart.id = ?
      LIMIT 1
    ");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      $data = [
        'id' => $row['id'],
        'nama' => $row['nama'],
        'gambar' => $row['gambar'],
        'qty' => (int)$row['qty'],
        'harga' => (int)$row['harga'],
        'berat' => (int)$row['berat'],
        'kota_tujuan' => $row['kota_tujuan'],
        'ekspedisi' => $row['ekspedisi']
      ];

      echo json_encode([
        'success' => true,
        'data' => $data
      ]);

    } else {
      echo json_encode([
        'success' => false,
        'message' => "Data dengan ID $id tidak ditemukan"
      ]);
    }

  } else {
    // Ambil semua data
    $stmt = $pdo->query("
      SELECT 
        cart.id,
        cart.qty,
        cart.kota_tujuan,
        cart.ekspedisi,
        productFish.nama,
        productFish.gambar,
        productFish.harga,
        productFish.berat
      FROM cart
      JOIN productFish ON cart.produk_id = productFish.id
      ORDER BY cart.created_at DESC
    ");

    $data = [];
    foreach ($stmt as $row) {
      $data[] = [
        'id' => $row['id'],
        'nama' => $row['nama'],
        'gambar' => $row['gambar'],
        'qty' => (int)$row['qty'],
        'harga' => (int)$row['harga'],
        'berat' => (int)$row['berat'],
        'kota_tujuan' => $row['kota_tujuan'],
        'ekspedisi' => $row['ekspedisi']
      ];
    }

    echo json_encode([
      'success' => true,
      'data' => $data
    ]);
  }

} catch (Exception $e) {
  echo json_encode([
    'success' => false,
    'message' => 'Gagal mengambil data cart',
    'error' => $e->getMessage()
  ]);
}
?>
