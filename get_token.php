<?php
// get_token.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// MASUKKAN SERVER KEY ANDA DI SINI
$serverKey = 'Mid-server-ceWqzg9QfPUVrE832hrBY4p1';

// Membuat Order ID unik berdasarkan waktu
$orderId = 'DEMO-FNB-' . time();

// Harga akses demo (Misal: Rp 15.000)
$grossAmount = 15000; 

// Payload data untuk dikirim ke Midtrans
$payload = [
    'transaction_details' => [
        'order_id' => $orderId,
        'gross_amount' => $grossAmount,
    ],
    'customer_details' => [
        'first_name' => 'Tamu',
        'last_name' => 'Demo',
        'email' => 'tamu@example.com',
    ]
];

// Menggunakan cURL untuk menembak API Midtrans
$ch = curl_init('https://app.sandbox.midtrans.com/snap/v1/transactions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    // Autentikasi menggunakan Basic Auth (Base64 dari ServerKey:)
    'Authorization: Basic ' . base64_encode($serverKey . ':')
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Kembalikan respons Midtrans (yang berisi token) ke JavaScript
echo $response;
?>

