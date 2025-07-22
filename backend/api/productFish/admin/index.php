<?php
$pdo = new PDO("mysql:host=localhost;dbname=dbkita", "root", "");

// Handle tambah/update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = isset($_POST['id']) && is_numeric($_POST['id']) ? (int)$_POST['id'] : null;
    $nama      = $_POST['nama'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $kategori  = $_POST['kategori'] ?? '';
    $berat     = is_numeric($_POST['berat']) ? $_POST['berat'] : 1;
    $harga     = is_numeric($_POST['harga']) ? $_POST['harga'] : 0;
    $gambar    = '';

    // Upload gambar jika ada
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $namaFile = time() . '_' . basename($_FILES['gambar']['name']);
        $uploadPath = __DIR__ . '/../upload/' . $namaFile;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadPath)) {
            $gambar = $namaFile;
        }
    }

    if ($id) {
        // Update
        $query = "UPDATE productFish SET nama=?, deskripsi=?, kategori=?, berat=?, harga=?";
        $params = [$nama, $deskripsi, $kategori, $berat, $harga];

        if ($gambar) {
            $query .= ", gambar=?";
            $params[] = $gambar;
        }

        $query .= " WHERE id=?";
        $params[] = $id;

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
    } else {
        // Tambah baru
        $stmt = $pdo->prepare("INSERT INTO productFish (nama, deskripsi, kategori, berat, harga, gambar) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama, $deskripsi, $kategori, $berat, $harga, $gambar]);
    }

    header("Location: index.php");
    exit;
}

// Hapus produk
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $stmt = $pdo->prepare("DELETE FROM productFish WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// Ambil semua produk
$produk = $pdo->query("SELECT * FROM productFish ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Edit data (jika ada)
$edit = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM productFish WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Produk Ikan</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #d4fcf9, #c2e9fb);
      color: #2c3e50;
      padding: 40px;
    }

    h2 {
      color: #146c94;
      margin-top: 40px;
    }

    .container {
      max-width: 1100px;
      margin: auto;
      padding: 20px;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      backdrop-filter: blur(10px);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: white;
      border-radius: 12px;
      overflow: hidden;
    }

    th {
      background-color: #6dc6d8;
      color: white;
      padding: 12px;
    }

    td {
      padding: 10px;
      text-align: center;
      border-bottom: 1px solid #e9f7fb;
    }

    tr:nth-child(even) {
      background-color: #f6fcff;
    }

    img {
      max-height: 60px;
      border-radius: 6px;
    }

    a {
      text-decoration: none;
      font-weight: bold;
      padding: 6px 10px;
      border-radius: 6px;
    }

    a.edit {
      background: #e0f3ff;
      color: #0275d8;
    }

    a.hapus {
      background: #ffebeb;
      color: #d9534f;
    }

    form {
      margin-top: 30px;
      background: rgba(255, 255, 255, 0.7);
      padding: 24px;
      border-radius: 16px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.07);
    }

    label {
      display: block;
      margin-top: 14px;
      font-weight: 600;
      color: #146c94;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #b7e3f0;
      border-radius: 8px;
      background: #f9feff;
    }

    button {
      margin-top: 20px;
      padding: 10px 22px;
      background: #3db4d3;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #289bb6;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>📦 Daftar Produk Ikan</h2>

    <table>
      <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Kategori</th>
        <th>Berat</th>
        <th>Harga</th>
        <th>Gambar</th>
        <th>Aksi</th>
      </tr>
      <?php foreach ($produk as $row): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
        <td><?= htmlspecialchars($row['kategori']) ?></td>
        <td><?= $row['berat'] ?></td>
        <td>Rp <?= number_format($row['harga']) ?></td>
        <td>
          <?php if ($row['gambar']): ?>
            <img src="../upload/<?= $row['gambar'] ?>" alt="">
          <?php endif ?>
        </td>
        <td>
          <a href="?edit=<?= $row['id'] ?>" class="edit">✏️ Edit</a> |
          <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus produk ini?')" class="hapus">🗑️ Hapus</a>
        </td>
      </tr>
      <?php endforeach ?>
    </table>

    <h2><?= $edit ? '🔁 Edit Produk' : '➕ Tambah Produk Baru' ?></h2>

    <form method="POST" enctype="multipart/form-data">
      <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= $edit['id'] ?>">
      <?php endif ?>
      <label>Nama Produk:</label>
      <input type="text" name="nama" value="<?= $edit['nama'] ?? '' ?>">

      <label>Deskripsi:</label>
      <textarea name="deskripsi"><?= $edit['deskripsi'] ?? '' ?></textarea>

      <label>Kategori:</label>
      <input type="text" name="kategori" value="<?= $edit['kategori'] ?? '' ?>">

      <label>Berat (kg):</label>
      <input type="number" name="berat" value="<?= $edit['berat'] ?? 1 ?>" step="0.1">

      <label>Harga:</label>
      <input type="number" name="harga" value="<?= $edit['harga'] ?? 0 ?>">

      <label>Gambar:</label>
      <input type="file" name="gambar">

      <button type="submit"><?= $edit ? '✅ Update' : '💾 Simpan' ?></button>
    </form>
  </div>
</body>


</html>
