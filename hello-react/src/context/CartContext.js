import React, { createContext, useState } from 'react';

export const CartContext = createContext();

export const CartProvider = ({ children }) => {
  const [keranjang, setKeranjang] = useState([]);

  // Menambahkan produk ke keranjang
  const addToCart = (produk) => {
    // Cek apakah produk sudah ada di keranjang
    const existingItem = keranjang.find(item => item.id === produk.id);
    
    if (existingItem) {
      // Jika produk sudah ada, hanya update qty
      setKeranjang(keranjang.map(item => 
        item.id === produk.id 
          ? { ...item, qty: item.qty + 1 } 
          : item
      ));
    } else {
      // Jika produk belum ada, tambah produk baru dengan qty 1
      setKeranjang([...keranjang, { ...produk, qty: 1 }]);
    }
  };

  // Mengubah jumlah qty produk di keranjang
  const updateQty = (id, delta) => {
    setKeranjang((items) =>
      items.map((item) =>
        item.id === id
          ? { ...item, qty: Math.max(1, item.qty + delta) } // Pastikan qty tidak kurang dari 1
          : item
      )
    );
  };

  // Menghapus item dari keranjang
  const removeItem = (id) => {
    setKeranjang((items) => items.filter((item) => item.id !== id));
  };

  return (
    <CartContext.Provider value={{ keranjang, setKeranjang, addToCart, updateQty, removeItem }}>
      {children}
    </CartContext.Provider>
  );
};
