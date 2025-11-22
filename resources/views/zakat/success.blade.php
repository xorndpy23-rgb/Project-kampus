<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Berhasil | Masjid Al-Muttaqin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .back-button {
            position: absolute;
            left: 20px;
            top: 20px;
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .back-button:hover {
            background: rgba(255,255,255,0.3);
            transform: translateX(-5px);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
    <a href="{{ url('/') }}" class="back-button">
        ←
    </a>

    <div class="min-h-screen flex items-center justify-center py-10">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-xl p-10 text-center">
            <h1 class="text-3xl font-extrabold text-green-600 mb-3">
                Pembayaran Berhasil!
            </h1>
            <p class="text-gray-600 mb-6">
                Terima kasih telah menunaikan Zakat. Transaksi Anda telah berhasil diproses.
            </p>

            <div class="space-x-4">
                <a href="/zakat" 
                   class="px-6 py-3 text-lg font-bold rounded-full text-white bg-green-600 hover:bg-green-700 shadow-lg">
                   💰 Bayar Zakat Lagi
                </a>
                <a href="/" 
                   class="px-6 py-3 text-lg font-bold rounded-full text-gray-700 bg-gray-200 hover:bg-gray-300 shadow-lg">
                   🏠 Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>