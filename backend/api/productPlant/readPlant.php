<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type");


// Koneksi DB
$conn = new mysqli("localhost", "root", "", "dbkita");
if ($conn->connect_error) {
  die(json_encode(["message" => "Koneksi gagal: " . $conn->connect_error]));
}

$sql = "SELECT * FROM productplant";
$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
  $products[] = $row;
}

echo json_encode($products);
$conn->close();
?>
