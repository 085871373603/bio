module.exports = async (req, res) => {
    // Kunci Server Midtrans Anda (Production)
    const serverKey = 'Mid-server-ceWqzg9QfPUVrE832hrBY4p1';
    const orderId = 'DEMO-FNB-' + Date.now();
    const grossAmount = 15000;

    // Payload data yang dikirim ke Midtrans
    const payload = {
        transaction_details: {
            order_id: orderId,
            gross_amount: grossAmount,
        },
        customer_details: {
            first_name: 'Tamu',
            last_name: 'Demo',
            email: 'tamu@example.com',
        }
    };

    try {
        // Proses request ke API Midtrans (URL PRODUCTION - TANPA SANDBOX)
        const response = await fetch('https://app.midtrans.com/snap/v1/transactions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // Encode Server Key ke Base64
                'Authorization': 'Basic ' + Buffer.from(serverKey + ':').toString('base64')
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();
        
        // Kirim token kembali ke HTML
        res.status(200).json(data);
    } catch (error) {
        // Menangkap error jika Vercel gagal menembak Midtrans
        res.status(500).json({ error: 'Gagal menghubungi Midtrans', detail: error.message });
    }
};
