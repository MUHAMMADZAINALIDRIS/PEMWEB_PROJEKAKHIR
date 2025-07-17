<?php
require 'db.php';
header("Access-Control-Allow-Origin: *"); // <- tambahkan ini agar tidak ditolak oleh CORS
header("Content-Type: application/json");

$result = $conn->query("SELECT * FROM productFish");

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>
