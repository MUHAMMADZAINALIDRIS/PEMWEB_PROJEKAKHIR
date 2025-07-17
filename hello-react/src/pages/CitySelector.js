import React from "react";

const CitySelector = ({ kotaList, selectedKota, onCityChange }) => {
  return (
    <div className="city-selector">
      <select
        value={selectedKota}
        onChange={(e) => onCityChange(e.target.value)}
        className="input-field mb-2"
      >
        <option value="">Pilih Kota Tujuan</option>
        {kotaList.map((kota) => (
          <option key={kota.city_id} value={kota.city_id}>
            {kota.city_name}
          </option>
        ))}
      </select>
    </div>
  );
};

export default CitySelector;
