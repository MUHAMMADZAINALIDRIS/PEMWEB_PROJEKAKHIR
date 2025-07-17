<?php
$cartData = json_decode(file_get_contents("http://localhost/backend/api/cart/readCart.php"), true);
$editData = null;


if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  foreach ($cartData['data'] as $item) {
    if ($item['id'] == $id) {
      $editData = $item;
      break;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Cart</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Nunito', sans-serif;
  background-color: #eaf6fb;
  color: #2d3e50;
  padding: 40px;
}

h2 {
  text-align: center;
  color: #3498db;
  margin-bottom: 30px;
  font-weight: 700;
}

.container {
  max-width: 1100px;
  margin: auto;
  background-color: #ffffff;
  padding: 30px;
  border-radius: 18px;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 30px;
}

th, td {
  padding: 14px;
  text-align: center;
  border-bottom: 1px solid #d0ecf5;
}

th {
  background-color: #d6f0fa;
  color: #247ba0;
}

tr:nth-child(even) {
  background-color: #f2fbff;
}

tr:hover {
  background-color: #e0f5ff;
}

img {
  max-height: 60px;
  border-radius: 6px;
  object-fit: cover;
}

a {
  text-decoration: none;
  font-weight: bold;
  padding: 6px 12px;
  border-radius: 8px;
  display: inline-block;
  margin: 2px;
  font-size: 13px;
}

a.edit {
  background-color: #d0edff;
  color: #176d98;
}

a.hapus {
  background-color: #ffe1e1;
  color: #c0392b;
}

form {
  background-color: #f4fbfe;
  padding: 24px;
  border-radius: 16px;
  border: 1px solid #d6ecf3;
}

label {
  font-weight: 600;
  display: block;
  margin-top: 12px;
  margin-bottom: 6px;
  color: #2980b9;
}

input[type="text"],
input[type="number"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #cce6f3;
  border-radius: 8px;
  background: #ffffff;
  font-size: 14px;
  color: #444;
}

input[type="text"]:focus,
input[type="number"]:focus {
  outline: none;
  border-color: #79c4f2;
  box-shadow: 0 0 0 3px rgba(121, 196, 242, 0.2);
}

button {
  margin-top: 20px;
  background-color: #3498db;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 10px;
  font-weight: bold;
  font-size: 15px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #2c80b4;
}

.actions {
  display: flex;
  justify-content: center;
  gap: 6px;
}

.total-row {
  background-color: #dff4fd;
  font-weight: bold;
}

.product-card {
  border: 1px solid #d3edf7;
  border-radius: 12px;
  padding: 14px;
  width: 220px;
  background: #f0fbff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
  transition: 0.3s ease;
}

.product-card:hover {
  box-shadow: 0 4px 12px rgba(150, 150, 150, 0.1);
}

.tambah-btn {
  background-color: #3498db;
  color: white;
  padding: 8px 12px;
  border-radius: 6px;
  border: none;
  font-size: 13px;
  cursor: pointer;
}

.tambah-btn:hover {
  background-color: #2c80b4;
}

@media (max-width: 768px) {
  .container { padding: 20px; }
  table { font-size: 13px; }
  .product-card { width: 100%; }
}

  </style>
</head>
<body>
  <div class="container">
    <h2>🛒 Monitoring Cart Pelanggan</h2>

    <table>
      <tr>
        <th>Nama</th>
        <th>Qty</th>
        <th>Harga Satuan</th>
        <th>Total Harga</th>
        <th>Berat</th>
        <th>Kota Tujuan</th>
        <th>Ekspedisi</th>
        <th>Gambar</th>
        <th>Aksi</th>
      </tr>
      <?php 
        $grandTotal = 0;
        foreach ($cartData['data'] as $item): 
          $total = $item['qty'] * $item['harga'];
          $grandTotal += $total;
      ?>
      <tr>
        <td><?= htmlspecialchars($item['nama']) ?></td>
        <td><?= $item['qty'] ?></td>
        <td>Rp <?= number_format($item['harga']) ?></td>
        <td>Rp <?= number_format($total) ?></td>
        <td><?= $item['berat'] ?> kg</td>
        <td><?= $item['kota_tujuan'] ?></td>
        <td><?= $item['ekspedisi'] ?></td>
        <td>
          <?php if (!empty($item['gambar'])): ?>
            <img src="../../productFish/upload/<?= $item['gambar'] ?>" alt="">
          <?php else: ?>
            -
          <?php endif ?>
        </td>
        <td class="actions">
          <a href="?edit=<?= $item['id'] ?>" class="edit">✏️</a>
          <a href="hapusCart.php?id=<?= $item['id'] ?>" class="hapus" onclick="return confirm('Hapus item ini?')">🗑️</a>
        </td>
      </tr>
      <?php endforeach ?>
      <tr class="total-row">
        <td colspan="3">Grand Total</td>
        <td colspan="6">Rp <?= number_format($grandTotal) ?></td>
      </tr>
    </table>

    <h2>🐟 Pilih Produk Ikan</h2>
<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
  <?php
    $fishProducts = json_decode(file_get_contents("http://localhost/backend/api/productFish/read.php"), true);
    foreach ($fishProducts as $fish):
  ?>
    <div style="border: 1px solid #ddd; border-radius: 10px; padding: 10px; width: 200px; background: #f0fbff;">
      <img src="../../productFish/upload/<?= $fish['gambar'] ?>" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
      <h4 style="margin: 10px 0 5px"><?= $fish['nama'] ?></h4>
      <p style="margin: 0;">Rp <?= number_format($fish['harga']) ?></p>
      <form method="POST" action="simpanCart.php">
        <input type="hidden" name="produk_id" value="<?= $fish['id'] ?>">
        <input type="hidden" name="nama" value="<?= $fish['nama'] ?>">
        <input type="hidden" name="qty" value="1">
        <input type="hidden" name="harga" value="<?= $fish['harga'] ?>">
        <input type="hidden" name="berat" value="<?= $fish['berat'] ?>">
        <input type="hidden" name="gambar" value="<?= $fish['gambar'] ?>">
        <input type="hidden" name="kota_tujuan" value="Jakarta">
        <input type="hidden" name="ekspedisi" value="JNE">
        <button 
        type="button" 
              onclick="isiFormCart('<?= $fish['nama'] ?>', <?= $fish['harga'] ?>, <?= $fish['berat'] ?>, '<?= $fish['gambar'] ?>', <?= $fish['id'] ?>)">
            + Tambah ke Cart
        </button>

      </form>
    </div>
  <?php endforeach ?>
</div>

    <h2><?= $editData ? '✏️ Edit Cart' : '➕ Tambah ke Cart' ?></h2>

    <form method="POST" action="simpanCart.php">
    <?php if ($editData): ?>
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
    <?php endif ?>
    
    <label>Nama:</label>
    <input type="text" name="nama" id="form-nama" value="<?= $editData['nama'] ?? '' ?>">
    <input type="hidden" name="produk_id" id="form-produk-id" value="<?= $editData['produk_id'] ?? '' ?>">

    <label>Qty:</label>
    <input type="number" name="qty" id="form-qty" value="<?= $editData['qty'] ?? 1 ?>">

    <label>Harga (Rp):</label>
    <input type="number" name="harga" id="form-harga" value="<?= $editData['harga'] ?? '' ?>">

    <label>Berat (kg):</label>
    <input type="number" name="berat" id="form-berat" value="<?= $editData['berat'] ?? '' ?>">

    <label>Kota Tujuan:</label>
    <input type="text" name="kota_tujuan" id="form-kota" value="<?= $editData['kota_tujuan'] ?? 'Jakarta' ?>">

    <label>Ekspedisi:</label>
    <input type="text" name="ekspedisi" id="form-ekspedisi" value="<?= $editData['ekspedisi'] ?? 'JNE' ?>">

    <label>Gambar (nama file):</label>
    <input type="text" name="gambar" id="form-gambar" value="<?= $editData['gambar'] ?? '' ?>">

    <button type="submit"><?= $editData ? '✅ Update' : '💾 Simpan' ?></button>
</form>

  </div>
</body>

<script>
function isiFormCart(nama, harga, berat, gambar, produk_id) {
  document.querySelector('input[name="produk_id"]').value = produk_id;
  document.getElementById('form-produk-id').value = produk_id;
  document.getElementById('form-nama').value = nama;
  document.getElementById('form-harga').value = harga;
  document.getElementById('form-berat').value = berat;
  document.getElementById('form-qty').value = 1;
  document.getElementById('form-kota').value = 'Jakarta';
  document.getElementById('form-ekspedisi').value = 'JNE';
  document.getElementById('form-gambar').value = gambar;

  document.getElementById('form-nama').focus();
  document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
}
</script>

</html>
