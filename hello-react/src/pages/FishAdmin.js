// src/pages/FishAdmin.js
import React, { useEffect, useState } from "react";
import axios from "axios";

const API_URL = "http://localhost/backend/api/productFish/";

const FishAdmin = () => {
  const [produkList, setProdukList] = useState([]);
  const [formData, setFormData] = useState({
    id: null,
    nama: "",
    deskripsi: "",
    kategori: "hias",
    harga: "",
    gambar: null,
  });

  const [isEdit, setIsEdit] = useState(false);

  useEffect(() => {
    fetchProduk();
  }, []);

  const fetchProduk = async () => {
    const res = await axios.get(`${API_URL}read.php`);
    setProdukList(res.data);
  };

  const handleInputChange = (e) => {
    const { name, value, files } = e.target;
    if (name === "gambar") {
      setFormData({ ...formData, gambar: files[0] });
    } else {
      setFormData({ ...formData, [name]: value });
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    let namaFileGambar = null;

    if (formData.gambar) {
      const uploadData = new FormData();
      uploadData.append("file", formData.gambar); // Sesuai dengan upload.php

      try {
        const uploadRes = await axios.post(`${API_URL}upload.php`, uploadData);
        if (uploadRes.data.status === "success") {
          namaFileGambar = uploadRes.data.filename;
        } else {
          alert("Upload gambar gagal: " + uploadRes.data.message);
          return;
        }
      } catch (err) {
        console.error("Upload error:", err);
        alert("Gagal upload gambar.");
        return;
      }
    }

    const payload = {
      nama: formData.nama,
      deskripsi: formData.deskripsi,
      kategori: formData.kategori,
      harga: formData.harga,
      gambar: namaFileGambar ?? (isEdit ? undefined : null),
    };

    if (isEdit) {
      payload.id = formData.id;
    }

    try {
      const endpoint = isEdit ? "update.php" : "create.php";
      await axios.post(`${API_URL}${endpoint}`, payload, {
        headers: { "Content-Type": "application/json" },
      });

      setFormData({
        id: null,
        nama: "",
        deskripsi: "",
        kategori: "hias",
        harga: "",
        gambar: null,
      });
      setIsEdit(false);
      fetchProduk();
    } catch (err) {
      console.error(err);
      alert("Gagal menyimpan data produk.");
    }
  };

  const handleEdit = (produk) => {
    setFormData({
      id: produk.id,
      nama: produk.nama,
      deskripsi: produk.deskripsi,
      kategori: produk.kategori,
      harga: produk.harga,
      gambar: null,
    });
    setIsEdit(true);
  };

  const handleDelete = async (id) => {
    if (!window.confirm("Yakin ingin menghapus produk ini?")) return;
    try {
      await axios.post(`${API_URL}delete.php`, { id }, {
      headers: { "Content-Type": "application/json" },
      });
      fetchProduk();
    } catch (err) {
      console.error(err);
      alert("Gagal menghapus produk.");
    }
  };

  return (
    <div className="p-6">
      <h2 className="text-2xl font-bold mb-4">Admin Produk Ikan</h2>

      <form onSubmit={handleSubmit} className="mb-8 space-y-2">
        <input type="text" name="nama" placeholder="Nama Ikan" value={formData.nama} onChange={handleInputChange} required />
        <input type="text" name="deskripsi" placeholder="Deskripsi" value={formData.deskripsi} onChange={handleInputChange} />
        <select name="kategori" value={formData.kategori} onChange={handleInputChange}>
          <option value="hias">Hias</option>
          <option value="konsumsi">Konsumsi</option>
        </select>
        <input type="number" name="harga" placeholder="Harga" value={formData.harga} onChange={handleInputChange} required />
        <input type="file" name="gambar" accept="image/*" onChange={handleInputChange} />
        <button type="submit">{isEdit ? "Update" : "Tambah"} Produk</button>
      </form>

      <table border="1" cellPadding="8" className="w-full text-left">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {produkList.map((item) => (
            <tr key={item.id}>
              <td>{item.id}</td>
              <td>{item.nama}</td>
              <td>{item.deskripsi}</td>
              <td>{item.kategori}</td>
              <td>Rp {parseInt(item.harga).toLocaleString()}</td>
              <td>
                {item.gambar && (
                  <img
                    src={`http://localhost/backend/api/productFish/upload/${item.gambar}`}
                    alt={item.nama}
                    width="60"
                  />
                )}
              </td>
              <td>
                <button onClick={() => handleEdit(item)}>Edit</button> |{" "}
                <button onClick={() => handleDelete(item.id)}>Hapus</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default FishAdmin;
