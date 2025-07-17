import React from "react";
import logoTengah from "../assets/logo2.png";
import lacakIcon from "../assets/lacakPesanan.png";
import tipsIcon from "../assets/tips.png";
import keranjangIcon from "../assets/keranjang.png";
import produkIcon from "../assets/produk.png";
import berandaIcon from "../assets/beranda.png";
import ikanIcon from "../assets/fish.png";
import tanamanIcon from "../assets/plant.png";
// Jangan import AdminPanel di Header, karena AdminPanel dipanggil di App.js via routing
import { Link } from "react-router-dom";
// import { CartContext } from "../context/CartContext";

function Header() {
  return (
    <header>
      <div className="logoPojok">
        <img src={logoTengah} alt="Logo Aqua Flora" />
      </div>
      <nav>
        <Link to="/order-tracking">
          Lacak Pesanan
          <img src={lacakIcon} alt="Lacak Icon" className="nav-icon" />
        </Link>
        <Link to="/Tips">
          Tips
          <img src={tipsIcon} alt="Tips Icon" className="nav-icon" />
        </Link>
        <Link to="/Cart">
          Keranjang
          <img src={keranjangIcon} alt="Keranjang Icon" className="nav-icon" />
        </Link>
        <div className="dropdown">
          <span className="dropbtn">
            Produk
            <img src={produkIcon} alt="Produk Icon" className="nav-icon" />
          </span>
          <div className="dropdown-content">
            <Link to="/product/ikan" className="submenu-item">
              <img src={ikanIcon} alt="Ikan" className="submenu-icon" />
              Ikan
            </Link>
            <Link to="/product/tanaman" className="submenu-item">
              <img src={tanamanIcon} alt="Tanaman" className="submenu-icon" />
              Tanaman
            </Link>
          </div>
        </div>
        <Link to="/Home">
          Home
          <img src={berandaIcon} alt="Beranda Icon" className="nav-icon" />
        </Link>
        
        {/* Tambahkan link ke Admin */}
        <Link to="/admin">
          Admin
          {/* Kalau ada icon khusus admin, bisa taruh di sini */}
        </Link>
      </nav>
    </header>
  );
}

export default Header;
