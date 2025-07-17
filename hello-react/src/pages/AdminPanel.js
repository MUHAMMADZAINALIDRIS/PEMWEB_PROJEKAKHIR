import React, { useEffect, useState } from 'react';

const API_BASE = 'http://192.168.51.192/backend/api/ProductFish/';

const AdminPanel = () => {
  const [produkList, setProdukList] = useState([]);
  const [formData, setFormData] = useState({
    nama: '',
    deskripsi: '',
    kategori: '',
    harga: '',
    gambar: ''
  });
  const [selectedFile, setSelectedFile] = useState(null);
  const [editId, setEditId] = useState(null);

  const fetchProduk = async () => {
    try {
      const res = await fetch(API_BASE + 'read.php');
      const data = await res.json();
      setProdukList(data);
    } catch (err) {
      console.error("Gagal fetch produk:", err);
    }
  };

  useEffect(() => {
    fetchProduk();
  }, []);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleFileChange = (e) => {
    setSelectedFile(e.target.files[0]);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    let gambar = formData.gambar; // default gambar lama
    if (selectedFile) {
      const formDataFile = new FormData();
      formDataFile.append('file', selectedFile);

      const uploadRes = await fetch(API_BASE + 'upload/upload.php', {
        method: 'POST',
        body: formDataFile
      });

      const uploadResult = await uploadRes.json();
      if (uploadResult.status === 'success') {
        gambar = uploadResult.filename;
      } else {
        alert('Upload gambar gagal');
        return;
      }
    }

    const url = API_BASE + (editId ? 'update.php' : 'create.php');
    const payload = { ...formData, gambar };
    if (editId) payload.id = editId;

    const res = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });

    const result = await res.json();
    alert(result.message);

    // Reset form
    setFormData({ nama: '', deskripsi: '', kategori: '', harga: '', gambar: '' });
    setSelectedFile(null);
    setEditId(null);
    fetchProduk();
  };

  const handleEdit = (produk) => {
    setFormData({
      nama: produk.nama,
      deskripsi: produk.deskripsi,
      kategori: produk.kategori,
      harga: produk.harga,
      gambar: produk.gambar // penting agar gambar lama tidak hilang
    });
    setEditId(produk.id);
    window.scrollTo({ top: 0, behavior: 'smooth' }); // scroll ke atas saat edit
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Yakin ingin menghapus produk ini?')) return;

    const res = await fetch(API_BASE + 'delete.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id })
    });

    const result = await res.json();
    alert(result.message);
    fetchProduk();
  };

  return (
    <div className="admin-panel">
      <h2>Admin Panel - Produk Ikan</h2>

      <form onSubmit={handleSubmit} className="form-produk">
        <input type="text" name="nama" placeholder="Nama Produk" value={formData.nama} onChange={handleChange} required />
        <input type="text" name="deskripsi" placeholder="Deskripsi" value={formData.deskripsi} onChange={handleChange} />
        <input type="text" name="kategori" placeholder="Kategori (hias/konsumsi)" value={formData.kategori} onChange={handleChange} required />
        <input type="number" name="harga" placeholder="Harga" value={formData.harga} onChange={handleChange} required />
        <input type="file" onChange={handleFileChange} />
        {formData.gambar && (
          <div style={{ marginTop: 8 }}>
            <small>Gambar sekarang:</small><br />
            <img src={`http://localhost/backend/upload/${formData.gambar}`} alt="Preview" width="120" />
          </div>
        )}
        <button type="submit">{editId ? 'Update Produk' : 'Tambah Produk'}</button>
      </form>

      <table className="produk-table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {produkList.map((produk) => (
            <tr key={produk.id}>
              <td>{produk.nama}</td>
              <td>{produk.deskripsi}</td>
              <td>{produk.kategori}</td>
              <td>Rp {parseInt(produk.harga).toLocaleString()}</td>
              <td>
                <img src={`http://localhost/backend/upload/${produk.gambar}`} alt={produk.nama} width="100" />
              </td>
              <td>
                <button onClick={() => handleEdit(produk)}>Edit</button>
                <button onClick={() => handleDelete(produk.id)} style={{ marginLeft: '10px', backgroundColor: 'red', color: 'white' }}>Hapus</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default AdminPanel;
