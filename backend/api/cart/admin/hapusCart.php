<?php
$id = $_GET['id'];
$ch = curl_init("http://localhost/backend/api/cart/deleteCart.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['id' => $id]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

header("Location: index.php");
