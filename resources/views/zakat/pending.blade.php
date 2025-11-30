<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Pending | Masjid Al-Muttaqin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex items-center justify-center py-10">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-xl p-10 text-center">
            <h1 class="text-3xl font-extrabold text-yellow-500 mb-3">
                Menghubungkan ke Midtrans...
            </h1>
            <p class="text-gray-600 mb-6">
                Mohon menunggu, halaman pembayaran sedang dibuka.
            </p>
        </div>
    </div>

    <!-- SNAP JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>

    <script>
        snap.pay("{{ $zakat->snap_token }}", {
            onSuccess: function(result){
                window.location.href = "/zakat/success/{{ $zakat->kode_transaksi }}";
            },
            onPending: function(result){
                // tetap di halaman pending
            },
            onError: function(result){
                alert("Terjadi kesalahan pembayaran.");
            },
            onClose: function(){
                alert("Anda menutup pembayaran sebelum selesai.");
            }
        });
    </script>

</body>
</html>
