<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Zakat Berhasil</title>
</head>
<body>
    <h2>Pembayaran Zakat Berhasil</h2>

    <p>Assalamualaikum {{ $zakat->nama }},</p>

    <p>Pembayaran zakat Anda telah berhasil diproses. Berikut detailnya:</p>

    <ul>
        <li>Order ID: {{ $zakat->kode_transaksi }}</li>
        <li>Nominal: Rp{{ number_format($zakat->nominal, 0, ',', '.') }}</li>
        <li>Jenis Zakat: {{ ucfirst($zakat->jenis_zakat) }}</li>
        <li>Status: {{ ucfirst($zakat->status) }}</li>
    </ul>

    <p>Terima kasih telah berzakat melalui Masjid Online.</p>
</body>
</html>
