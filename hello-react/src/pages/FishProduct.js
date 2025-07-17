import React, { useEffect, useState, useContext } from 'react';
import { CartContext } from '../context/CartContext';
import ikanDefault from '../assets/gabus.jpeg'; // fallback gambar default

const FishProduct = () => {
  const [selectedProduct, setSelectedProduct] = useState(null);
  const [filter, setFilter] = useState('semua');
  const [searchTerm, setSearchTerm] = useState('');
  const { keranjang } = useContext(CartContext);
  const [produkList, setProdukList] = useState([]);

  useEffect(() => {
    fetch('http://localhost/backend/api/ProductFish/read.php')
      .then(res => res.json())
      .then(data => {
        console.log("Data produk:", data); // 🔍 cek isi
        setProdukList(data);
      })
      .catch(error => console.error('Gagal fetch produk:', error));
  }, []);

  const filteredProduk = (produkList || []).filter((produk) => {
    const cocokKategori = filter === 'semua' || produk.kategori === filter;
    const cocokPencarian = produk.nama.toLowerCase().includes(searchTerm.toLowerCase());
    return cocokKategori && cocokPencarian;
  });

  const handleDetailClick = (produk) => {
    setSelectedProduct(produk);
  };

  const closePopup = () => {
    setSelectedProduct(null);
  };

  const handleAddToCart = async (produk) => {
    const payload = {
      produk_id: produk.id,
      nama_produk: produk.nama,
      berat: produk.berat,
      harga: produk.harga,
      qty: 1,
      kota_tujuan: "Jakarta",
      ekspedisi: "JNE",
      gambar: produk.gambar || null,
    };

    try {
      const res = await fetch("http://localhost/backend/api/cart/createCart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(payload),
      });

      const result = await res.json();
      console.log("📦 RESPON DARI SERVER:", result);

      if (result.success) {
        alert("Berhasil ditambahkan ke keranjang!");
      } else {
        alert("Gagal: " + result.message);
      }
    } catch (err) {
      console.error("❌ ERROR SAAT REQUEST:", err.message || err);
    }
  };

  return (
    <div className="produk-section">
      <div className="filter-box">
        <div className="filter-header">
          <h2>Filter Produk</h2>
          <input
            type="text"
            placeholder="Cari ikan..."
            className="search-input"
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>

        <div className="filter-buttons">
          <button onClick={() => setFilter('semua')}>Semua</button>
          <button onClick={() => setFilter('hias')}>Ikan Hias</button>
          <button onClick={() => setFilter('konsumsi')}>Ikan Konsumsi</button>
        </div>
      </div>

      <div className="produk-grid">
        {filteredProduk.map((produk) => (
          <div key={produk.id} className="produk-card">
            <img
              src={
                produk.gambar
                  ? `http://localhost/backend/api/productFish/upload/${produk.gambar}`
                  : ikanDefault
              }
              alt={produk.nama}
              width="100%"
            />
            <div className="produk-info">
              <h3>{produk.nama}</h3>
              <p>{produk.deskripsi}</p>
              <p className="harga">Rp {parseInt(produk.harga).toLocaleString()}</p>
              <button className="detail-btn" onClick={() => handleDetailClick(produk)}>
                Detail
              </button>
              <button className="add-btn" onClick={() => handleAddToCart(produk)}>
                Tambah
              </button>
            </div>
          </div>
        ))}
      </div>

      {/* Keranjang */}
      <div className="keranjang">
        <h2>Keranjang</h2>
        {Array.isArray(keranjang) && keranjang.length > 0 ? (
          <ul>
            {keranjang.map((produk, index) => (
              <li key={index}>
                {produk.nama} - {produk.berat} kg
              </li>
            ))}
          </ul>
        ) : (
          <p>Keranjang Anda masih kosong.</p>
        )}
      </div>

      {/* Modal Detail */}
      {selectedProduct && (
        <div className="modal">
          <div className="modal-content">
            <button className="close-btn" onClick={closePopup}>×</button>
            <img
              src={
                selectedProduct.gambar
                  ? `http://localhost/backend/api/ProductFish/upload/${selectedProduct.gambar}`
                  : ikanDefault
              }
              alt={selectedProduct.nama}
              className="modal-img"
            />
            <h3>{selectedProduct.nama}</h3>
            <p>{selectedProduct.deskripsi}</p>
            <div className="detail-info">
              <span>Kategori: {selectedProduct.kategori}</span>
              <span>Berat: {selectedProduct.berat} kg</span>
              <span>Harga: Rp {parseInt(selectedProduct.harga).toLocaleString()}</span>
            </div>
            <button className="add-btn" onClick={() => handleAddToCart(selectedProduct)}>
              Tambah
            </button>
          </div>
        </div>
      )}
    </div>
  );
};

export default FishProduct;
