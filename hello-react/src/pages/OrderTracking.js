import React, { useState } from 'react';


const OrderTracking = () => {
  const [orderId, setOrderId] = useState('');
  const [phoneNumber, setPhoneNumber] = useState('');

  const handleOrderIdChange = (e) => setOrderId(e.target.value);
  const handlePhoneNumberChange = (e) => setPhoneNumber(e.target.value);

  const handleSubmit = (e) => {
    e.preventDefault();
    // Anda bisa menambahkan logika pengiriman data ke server untuk melacak pesanan
    console.log(`Melacak pesanan dengan Order ID: ${orderId} dan Nomor HP: ${phoneNumber}`);
  };

  return (
    <div className="order-tracking-container">
      <h2>Lacak Pesanan</h2>
      <p>Silahkan masukkan informasi berikut untuk melacak status pesanan Anda.</p>

      <form onSubmit={handleSubmit} className="order-tracking-form">
        <div className="input-group">
          <label htmlFor="order-id">Order ID</label>
          <input
            type="text"
            id="order-id"
            value={orderId}
            onChange={handleOrderIdChange}
            placeholder="Masukkan Order ID"
            required
          />
        </div>

        <div className="input-group">
          <label htmlFor="phone-number">Nomor HP</label>
          <input
            type="tel"
            id="phone-number"
            value={phoneNumber}
            onChange={handlePhoneNumberChange}
            placeholder="Masukkan Nomor HP"
            required
          />
        </div>

        <button type="submit" className="submit-btn">Lacak Pesanan</button>
      </form>
    </div>
  );
};

export default OrderTracking;
