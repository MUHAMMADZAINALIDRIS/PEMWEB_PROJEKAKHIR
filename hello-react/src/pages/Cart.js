import { useState, useEffect, useContext } from "react";
import { CartContext } from "../context/CartContext";
import logoDana from '../assets/logo-dana.png';
import axios from 'axios';


const Cart = () => {
  const { keranjang, setKeranjang } = useContext(CartContext);
  const [selectedItems, setSelectedItems] = useState([]);
  const [userData, setUserData] = useState({
    nama: "",
    alamat: "",
    telepon: "",
  });

  useEffect(() => {
    axios.get("http://192.168.51.192/backend/api/cart/readCart.php")
      .then(res => {
        console.log("🔍 ISI KERANJANG DARI SERVER:", res.data);
        setKeranjang(res.data.data);
      })
      .catch(err => {
        console.error("Gagal memuat cart:", err);
      });
  }, [setKeranjang]);

  const [ongkir, setOngkir] = useState(null);
  const [kotaTujuan] = useState("");
  const [kurir, setKurir] = useState("jne");

  const isUserDataComplete = userData.nama && userData.alamat && userData.telepon;

  const toggleSelectItem = (id) => {
    setSelectedItems((prev) =>
      prev.includes(id)
        ? prev.filter((itemId) => itemId !== id)
        : [...prev, id]
    );
  };

  const total = (keranjang || [])
    .filter((item) => selectedItems.includes(item.id))
    .reduce((sum, item) => sum + item.harga * item.qty, 0);

  const getOngkir = async () => {
    const selectedItemsList = (keranjang || []).filter(item => selectedItems.includes(item.id));
    const beratTotal = selectedItemsList.reduce((sum, item) => sum + item.berat * item.qty, 0);

    try {
      const res = await axios.post("http://192.168.51.192/backend/api/ongkir/getOngkirFromDB.php", {
        origin: "Cirebon",
        destination: kotaTujuan,
        courier: kurir
      });

      if (res.data.success) {
        const ongkirPerKg = res.data.ongkir_per_kg;
        const totalOngkir = ongkirPerKg * beratTotal;
        setOngkir({ perKg: ongkirPerKg, value: totalOngkir });
      } else {
        alert("Gagal hitung ongkir: " + res.data.message);
      }
    } catch (err) {
      alert("Terjadi kesalahan saat mengambil ongkir.");
      console.error(err);
    }
  };

  const updateQty = async (id, delta) => {
    const item = (keranjang || []).find(i => i.id === id);
    if (!item) return;

    const newQty = Math.max(1, item.qty + delta);

    try {
      await axios.put('http://192.168.51.192/backend/api/cart/updateCart.php', {
        id: item.id,
        qty: newQty,
        kota_tujuan: item.kota_tujuan,
        ekspedisi: item.ekspedisi
      });

      const res = await axios.get("http://192.168.51.192/backend/api/cart/readCart.php");
      setKeranjang(res.data.data);
    } catch (err) {
      console.error("Gagal update qty:", err);
    }
  };

  const removeItem = async (id) => {
    try {
      await axios.delete('http://192.168.51.192/backend/api/cart/deleteCart.php', {
        data: { id }
      });

      const res = await axios.get("http://192.168.51.192/backend/api/cart/readCart.php");
      setKeranjang(res.data.data);
    } catch (err) {
      console.error("Gagal menghapus item:", err);
    }
  };

  const handleCheckout = () => {
    if (!isUserDataComplete) {
      alert('Lengkapi data diri Anda terlebih dahulu!');
      return;
    }
    alert('Melanjutkan ke pembayaran...');
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setUserData({
      ...userData,
      [name]: value,
    });
  };

  const formatRupiah = (angka) => {
    if (!angka) return "Rp 0";
    return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  };

  return (
    <div className="cart-page-horizontal flex">
      <div className="cart-items w-2/3 p-6">
        <h2 className="text-3xl font-bold mb-6">Keranjang Belanja</h2>

        {(keranjang || []).length === 0 ? (
          <div className="empty-cart">
            <p>Keranjang Anda masih kosong. Silakan tambahkan produk.</p>
          </div>
        ) : (
          (keranjang || []).map((item) => (
            <div key={item.id} className="cart-item flex items-center mb-4">
              <input
                type="checkbox"
                checked={selectedItems.includes(item.id)}
                onChange={() => toggleSelectItem(item.id)}
                className="checkbox mr-4"
              />
              <img src={`http://192.168.51.192/backend/api/ProductFish/upload/${item.gambar}`} alt={item.nama} />
              <div className="item-info flex-grow">
                <h3 className="text-xl">{item.nama}</h3>
                <p className="price">Rp {(item.harga ?? 0).toLocaleString()}</p>
                <div className="qty-control">
                  <button onClick={() => updateQty(item.id, -1)}>-</button>
                  <span>{item.qty}</span>
                  <button onClick={() => updateQty(item.id, 1)}>+</button>
                </div>
              </div>
              <button onClick={() => removeItem(item.id)} className="hapus">
                Hapus
              </button>
            </div>
          ))
        )}
      </div>

      <div className="cart-summary">
        {selectedItems.length > 0 ? (
          <>
            <h3 className="summary-title">Ringkasan Belanja</h3>
            <ul className="summary-list">
              {(keranjang || [])
                .filter((item) => selectedItems.includes(item.id))
                .map((item) => (
                  <li key={item.id} className="summary-item">
                    <span>{item.nama} × {item.qty}</span>
                    <span>Rp {(item.harga * item.qty).toLocaleString()}</span>
                  </li>
                ))}
            </ul>

            <div className="ongkir-form mb-4">
              <h3 className="font-semibold mb-2">Pengiriman</h3>
              <select
                value={kurir}
                onChange={(e) => setKurir(e.target.value)}
                className="input-field mb-2"
              >
                <option value="jne">JNE</option>
                <option value="pos">POS</option>
                <option value="tiki">TIKI</option>
              </select>

              <button className="cek-ongkir-btn" onClick={getOngkir}>
                Cek Ongkir
              </button>
            </div>

            <div className="total">
              <p>Subtotal: {formatRupiah(total)}</p>
              <p>Ongkir: {formatRupiah(ongkir ? ongkir.value : 0)}</p>
              <p className="font-bold text-lg">
                Total Bayar: {formatRupiah(total + (ongkir?.value || 0))}
              </p>
            </div>

            <div className="user-data-form">
              <h3 className="text-lg font-semibold mb-4">Informasi Pemesan</h3>
              <input
                type="text"
                name="nama"
                placeholder="Nama Lengkap"
                value={userData.nama}
                onChange={handleInputChange}
                className="input-field mb-2"
              />
              <input
                type="text"
                name="alamat"
                placeholder="Alamat"
                value={userData.alamat}
                onChange={handleInputChange}
                className="input-field mb-2"
              />
              <input
                type="text"
                name="telepon"
                placeholder="Nomor Telepon"
                value={userData.telepon}
                onChange={handleInputChange}
                className="input-field mb-4"
              />
            </div>

            <p className="pay-label">Bayar sekarang :</p>

            <button
              className={`checkout-btn ${isUserDataComplete ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed'}`}
              disabled={!isUserDataComplete}
              onClick={handleCheckout}
            >
              <img src={logoDana} alt="Dana Logo" />
              {isUserDataComplete ? "" : " "}
            </button>
          </>
        ) : (
          <div className="empty-summary">
            <p>Silakan pilih barang yang akan dibayar.</p>
          </div>
        )}
      </div>
    </div>
  );
};

export default Cart;
