import React, { useEffect } from "react";
import { Link } from "react-router-dom";
import "./Home.js";
import logoTengah from "../assets/logo2.png";
import ikan from "../assets/lele.jpeg";
import tanaman from "../assets/wortel.png";
import Koi from "../assets/koi.jpeg";
import MawarMerah from "../assets/MawarMerah.jpeg";
import mas from "../assets/mas.jpeg";

function Home() {
  useEffect(() => {
    // Salju
    const style = document.createElement("style");
    style.innerHTML = `
      .snowflake {
        position: fixed;
        top: -10px;
        z-index: 9999;
        animation: fall 15s linear infinite;
        pointer-events: none;
        color: white;
      }
      @keyframes fall {
        to {
          transform: translateY(100vh) rotate(360deg);
        }
      }
    `;
    document.head.appendChild(style);

    const interval = setInterval(() => {
      const snowflake = document.createElement("div");
      snowflake.className = "snowflake";
      snowflake.style.left = Math.random() * 100 + "vw";
      snowflake.style.animationDelay = Math.random() * 5 + "s";
      snowflake.style.opacity = Math.random() + 0.5;
      snowflake.style.fontSize = Math.random() * 20 + 10 + "px";
      snowflake.innerHTML = "❄";
      document.body.appendChild(snowflake);

      setTimeout(() => {
        snowflake.remove();
      }, 15000);
    }, 500);

    return () => clearInterval(interval);
  }, []);

  const [showModal, setShowModal] = React.useState(false);

  return (
    <div className="content">
      <p>Welcome to</p>
      <h1>Aqua Flora</h1>
      <p>Nusantara</p>
      <div className="logoTengah">
        <img src={logoTengah} alt="Logo Aqua Flora" height="358" />
      </div>
      <div>
        <button className="btn-product" onClick={() => setShowModal(true)}>
          Mulai Menjelajah
        </button>
      </div>
      <div className="teksBawah">
        <p>~Ikan menari tanaman berseri~</p>
        <div className="p2">
          <p>
            Aqua Flora Nusantara menyediakan ikan hidup segar dan sehat untuk
            hobi
          </p>
          <p>dan budidaya. Siap kirim dengan aman ke seluruh Indonesia.</p>
        </div>
      </div>

      <div className="summary-section">
        {/* RINGKASAN PRODUK */}
        <section className="product-summary">
          <h2>Ringkasan Produk</h2>
          <div className="product-grid">
            <div className="product-card">
              <img src={ikan} alt="Ikan Lele" />
              <h3>Ikan Lele</h3>
            </div>
            <div className="product-card">
              <img src={tanaman} alt="Wortel" />
              <h3>Wortel</h3>
            </div>
            <div className="product-card">
              <img src={Koi} alt="koi" />
              <h3>Ikan Koi</h3>
            </div>
            <div className="product-card">
              <img src={MawarMerah} alt="Mawar Merah" />
              <h3>Mawar Merah</h3>
            </div>
            <div className="product-card">
              <img src={mas} alt="Ikan Mas" />
              <h3>Ikan Mas</h3>
            </div>
          </div>
        </section>

        <section className="tips-summary">
          <p>
            Ingin tahu lebih banyak tentang tips perawatan ikan dan tanaman?
          </p>
          <span>
            <Link to="/tips">
              <button className="btn-tips">Tips Selengkapnya</button>
            </Link>
          </span>
        </section>


      </div>

      {showModal && (
        <div className="modal-overlay">
          <div className="modal-content">
            <h2>Pilih Jenis Produk</h2>
            <div className="modal-buttons">
              <Link to="/product/ikan">
                <button className="modal-btn">Produk Ikan</button>
              </Link>
              <Link to="/product/tanaman">
                <button className="modal-btn">Produk Tanaman</button>
              </Link>
            </div>
            <button className="modal-close" onClick={() => setShowModal(false)}>
              Tutup
            </button>
          </div>
        </div>
      )}
    </div>
  );
}

export default Home;
