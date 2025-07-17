<?php
function getOngkir($kota, $ekspedisi) {
  $tarif = [
    'Jakarta' => ['JNE' => 10000, 'JNT' => 12000],
    'Bandung' => ['JNE' => 13000, 'JNT' => 15000],
    'Bekasi'  => ['JNE' => 9000,  'JNT' => 11000],
  ];

  return $tarif[$kota][$ekspedisi] ?? 0;
}
