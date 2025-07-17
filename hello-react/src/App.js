import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Header from "./components/Header";
import Footer from "./components/Footer";
import "./App.css";
import Home from "./pages/Home";
import FishProduct from "./pages/FishProduct";
import PlantProduct from "./pages/PlantProduct";
import Tips from "./pages/Tips";
import Cart from "./pages/Cart";
import OrderSummary from "./pages/OrderSummary";
import OrderTracking from "./pages/OrderTracking";
import AdminPanel from './pages/AdminPanel';
import { CartProvider } from './context/CartContext';
import FishAdmin from "./pages/FishAdmin";

function App() {
  return (
    <CartProvider>
      <BrowserRouter>
        <div className="app-wrapper">
          <Header />
          <main className="main-content">
            <Routes>
              <Route path="/home" element={<Home />} />
              <Route path="/product/ikan" element={<FishProduct />} />
              <Route path="/product/tanaman" element={<PlantProduct />} />
              <Route path="/tips" element={<Tips />} />
              <Route path="/cart" element={<Cart />} />
              <Route path="/order-summary" element={<OrderSummary />} />
              <Route path="/order-tracking" element={<OrderTracking />} />
              <Route path="/admin" element={<AdminPanel />} />
              <Route path="/admin/ikan" element={<FishAdmin />} />
            </Routes>
          </main>
          <Footer />
        </div>
      </BrowserRouter>
    </CartProvider>
  );
}
export default App;
