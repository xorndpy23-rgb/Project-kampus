<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Zakat - Masjid Al-Muttaqin</title>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #059669;
            --dark: #1F2937;
            --light: #F9FAFB;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #059669 0%, #10B981 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            max-width: 500px;
            width: 100%;
        }
        
        .payment-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }
        
        h2 {
            color: var(--dark);
            margin-bottom: 30px;
            font-size: 1.8rem;
        }
        
        .payment-info {
            background: var(--light);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: left;
            border-left: 5px solid var(--primary);
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--dark);
        }
        
        .info-value {
            color: #6B7280;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .status-pending {
            background: #FEF3C7;
            color: #D97706;
        }
        
        .btn-pay {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 18px 30px;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.4);
        }
        
        .security-note {
            margin-top: 20px;
            font-size: 0.875rem;
            color: #6B7280;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-card">
            <div class="icon">💰</div>
            <h2>Pembayaran Zakat</h2>
            
            <div class="payment-info">
                <div class="info-row">
                    <span class="info-label">Kode Transaksi:</span>
                    <span class="info-value">{{ $zakat->kode_transaksi }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $zakat->nama }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis Zakat:</span>
                    <span class="info-value">{{ ucfirst($zakat->jenis_zakat) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Metode Bayar:</span>
                    <span class="info-value">{{ ucfirst(str_replace('_', ' ', $zakat->payment_method)) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nominal:</span>
                    <span class="info-value">Rp {{ number_format($zakat->nominal, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="status-badge status-pending">{{ strtoupper($zakat->status) }}</span>
                </div>
            </div>

            <button class="btn-pay" id="pay-button">
                <span id="btn-text">💳 Bayar Sekarang</span>
                <span id="btn-loading" style="display: none;">
                    <span class="loading"></span> Memproses...
                </span>
            </button>
            
            <div class="security-note">
                <span>🔒</span>
                <span>Transaksi aman diproses oleh Midtrans</span>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            // Tampilkan loading
            document.getElementById('btn-text').style.display = 'none';
            document.getElementById('btn-loading').style.display = 'inline';
            document.getElementById('pay-button').disabled = true;

            var snapToken = '{{ $zakat->snap_token }}';
            
            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = '{{ url("/zakat/success/{$zakat->kode_transaksi}") }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ url("/zakat/pending/{$zakat->kode_transaksi}") }}';
                },
                onError: function(result) {
                    window.location.href = '{{ url("/zakat/pending/{$zakat->kode_transaksi}") }}';
                },
                onClose: function() {
                    // Reset button jika user tutup popup
                    document.getElementById('btn-text').style.display = 'inline';
                    document.getElementById('btn-loading').style.display = 'none';
                    document.getElementById('pay-button').disabled = false;
                }
            });
        };
    </script>
</body>
</html>