import React from "react";
import whatsappIcon from "../assets/whatsapp.png"
import instagramIcon from "../assets/instagram.png"
import locationIcon from "../assets/location.png"

function Footer() {
  return (
    <footer className="footer">
        <div className="footer-left"> 
            <p>Aqua <br/> Flora</p>
        </div>
        <div className="footer-sosmed">
            <span className="ikuti">Ikuti Kami di</span>

            <div className="sosmed-button">
                <a href="https://maps.app.goo.gl/KjSmf8Zy3fdTxNfK9" target="_blank" rel="noopener noreferrer">
                    <button className="btn-sosmed">
                    <img src={locationIcon} alt="Location" style={{ width: '25px', height: '25px'}} />
                    </button>
                </a>
                <a href="https://wa.me/628815109269" target="_blank" rel="noopener noreferrer">
                    <button className="btn-sosmed">
                    <img src={whatsappIcon} alt="WhatsApp" style={{ width: '25px', height: '25px'}} />
                    </button>
                </a>
                <a href="https://www.instagram.com/fkhaerani_?igsh=YWM0cmRsZ2ppOWVl" target="_blank" rel="noopener noreferrer">
                    <button className="btn-sosmed">
                    <img src={instagramIcon} alt="Instagram" style={{ width: '25px', height: '25px'}} />
                    </button>
                </a>
            </div>
            <p>© 2025 | Teknik Informatika 1 | Kelompok 5</p>
            
        </div>
    </footer>
  );
}

export default Footer;
