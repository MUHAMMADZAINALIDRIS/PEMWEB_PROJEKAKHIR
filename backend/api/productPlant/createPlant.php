<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type");


// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "dbkita");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Koneksi database gagal"]);
    exit();
}

// Validasi data POST dan FILES
if (
    !isset($_POST['namaP']) || !isset($_POST['deskripsiP']) || !isset($_POST['kategoriP']) ||
    !isset($_POST['beratP']) || !isset($_POST['hargaP']) || !isset($_FILES['gambarP'])
) {
    http_response_code(400);
    echo json_encode(["message" => "Data tidak lengkap"]);
    exit;
}

// Simpan file gambar ke folder upload
$upload_dir = __DIR__ . "/upload/"; // path absolut ke folder upload
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0775, true); // buat folder jika belum ada
}

$gambar_name = basename($_FILES["gambarP"]["name"]);
$target_file = $upload_dir . $gambar_name;

if (!move_uploaded_file($_FILES["gambarP"]["tmp_name"], $target_file)) {
    http_response_code(500);
    echo json_encode(["message" => "Gagal mengunggah gambar"]);
    exit;
}

// Simpan data ke database (nama file saja)
$query = "INSERT INTO productPlant (namaP, deskripsiP, kategoriP, beratP, hargaP, gambarP) 
          VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "sssdds",
    $_POST['namaP'],
    $_POST['deskripsiP'],
    $_POST['kategoriP'],
    $_POST['beratP'],
    $_POST['hargaP'],
    $gambar_name
);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode([
        "message" => "Produk berhasil ditambahkan",
        "id" => $stmt->insert_id
    ]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Gagal menambahkan produk"]);
}

$stmt->close();
$conn->close();
?>
