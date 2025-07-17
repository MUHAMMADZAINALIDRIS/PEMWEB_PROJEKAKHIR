import React, { useState } from 'react';
import video1 from '../assets/vid-1.mp4';
import video2 from '../assets/vid-2.mp4';
import video3 from '../assets/vid-3.mp4';
import video4 from '../assets/vid-4.mp4';
import video5 from '../assets/vid-5.mp4';
import video6 from '../assets/vid-6.mp4';

const Tips = () => {
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [currentContent, setCurrentContent] = useState(null);
  const [isArticle, setIsArticle] = useState(false);

  const tips = [
    {
      id: 1,
      title: 'Cara Budidaya Ikan Guppy Agar Cepat Beranak dan Berkembang',
      video: video1,
      isFeatured: true,
    },
    {
      id: 2,
      title: 'Cara Budidaya Ikan Koi Agar Cepat Besar Terbukti Berhasil! Wajib Coba !!',
      video: video2,
      isFeatured: true,
    },
    {
      id: 3,
      title: 'Cara Ternak Ikan Nila untuk Pemula',
      video: video3,
      isFeatured: true,
    },
    {
      id: 4,
      title: "Langkah-langkah Budidaya Ikan Gurame dari Awal sampe Panen",
      video: video4,
      isFeatured: true,
    },
    {
      id: 5,
      title: "Cara Mudah Agar Cabai Berbuah Lebat",
      video: video5,
      isFeatured: true,
    },
    {
      id: 6,
      title: "Cara Pemangkasan Tomat Agar Berbuah Lebat",
      video: video6,
      isFeatured: true,
    },
    {
      id: 7,
      title: "7 Tips Merawat Tanaman Hias",
      isFeatured: true,
      isArticle: true,
      url: "https://www.detik.com/properti/tips-dan-panduan/d-7315317/7-tips-merawat-tanaman-hias-supaya-tumbuh-sehat-dan-kuat-di-rumah",
    },
    {
      id: 8,
      title: "7 Tips Merawat Tanaman Hias",
      isFeatured: true,
      isArticle: true,
      url: "https://www.detik.com/bali/berita/d-6580860/13-jenis-tanaman-hidroponik-dan-cara-penanamannya-di-rumah",
    },
    {
      id: 9,
      title: "5 Tips Menyiram Tanaman Yang Tepat",
      isFeatured: true,
      isArticle: true,
      url: "https://www.kompas.com/homey/read/2022/02/11/203700676/5-tips-menyiram-tanaman-yang-tepat-agar-tidak-mati-dan-busuk",
    },
    {
      id: 10,
      title: "Waktu yang Pas dalam Pemberian Pakan Lele",
      isFeatured: true,
      isArticle: true,
      url: "https://www.isw.co.id/post/2017/04/04/waktu-pas-pemberian-pakan-lele",
    },
     {
      id: 11,
      title: "Daftar Air Terbaik Untuk Menyiram Tanaman",
      isFeatured: true,
      isArticle: true,
      url: "https://momsmoney.kontan.co.id/news/bukan-air-keran-ini-daftar-air-terbaik-untuk-menyiram-tanaman",
    },
    {
      id: 12,
      title: "4 Tips Membedakan Tanaman Hias Indoor dan Outdoor ",
      isFeatured: true,
      isArticle: true,
      url: "https://www.haibunda.com/moms-life/20220131121604-76-265843/4-tips-membedakan-tanaman-hias-indoor-dan-outdoor-tekstur-daun-hingga-kebutuhan-air",
    },
  ];

  const handleWatchClick = (content, isArticle = false) => {
    setCurrentContent(content);
    setIsArticle(isArticle);
    setIsModalOpen(true);
  };

  const closeModal = () => {
    setIsModalOpen(false);
    setCurrentContent(null);
    setIsArticle(false);
  };

  return (
    <div className="tips-section">
      <div className="tips-grid">
        {tips.map((tip) => (
          <div key={tip.id} className="tip-card featured">
            {!tip.isArticle ? (
              <>
                <video src={tip.video} className="tip-video" controls />
                <div className="tip-content">
                  <h3>{tip.title}</h3>
                  <button className="watch-btn" onClick={() => handleWatchClick(tip.video)}>
                    Tonton
                  </button>
                </div>
              </>
            ) : (
              <>
                <div className="tip-article-preview">
                  <h3>{tip.title}</h3>
                  <button className="watch-btn" onClick={() => handleWatchClick(tip.url, true)}>
                    Baca Artikel
                  </button>
                </div>
              </>
            )}
          </div>
        ))}
      </div>

      {isModalOpen && (
        <div className="modal">
          <div className="modal-content">
            <span className="close-btn" onClick={closeModal}>×</span>
            {isArticle ? (
              <iframe
                src={currentContent}
                className="modal-iframe"
                title="Artikel"
                frameBorder="0"
              ></iframe>
            ) : (
              <video src={currentContent} controls autoPlay className="modal-video" />
            )}
          </div>
        </div>
      )}
    </div>
  );
};

export default Tips;
