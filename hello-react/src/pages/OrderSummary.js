import React from "react";
import { useLocation } from "react-router-dom";

const OrderSummary = () => {
  const { state } = useLocation();
  const { items, subtotal } = state || {};
  const ongkir = 10000;
  const totalBayar = subtotal + ongkir;

  const handleBayar = () => {
    window.location.href = "https://link.dana.id"; // Ganti dengan link DANA sebenarnya
  };

  return (
    <div className="order-summary p-6 max-w-xl mx-auto bg-white rounded shadow">
      <h2 className="text-2xl font-bold mb-4">Ringkasan Pesanan</h2>
      {items.map((item) => (
        <div key={item.id} className="mb-2">
          <p>{item.nama} x {item.qty} = Rp {(item.price * item.qty).toLocaleString()}</p>
        </div>
      ))}
      <hr className="my-4" />
      <p>Subtotal: Rp {subtotal.toLocaleString()}</p>
      <p>Ongkir: Rp {ongkir.toLocaleString()}</p>
      <p className="font-bold mt-2">Total: Rp {totalBayar.toLocaleString()}</p>

      <button onClick={handleBayar} className="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
        Bayar via DANA
      </button>
    </div>
  );
};

export default OrderSummary;
