<!-- FIXED FORM ZAKAT DENGAN FORMAT RUPIAH BENAR -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Zakat - Masjid Al-Muttaqin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="create-page">

    <!-- TOMBOL KEMBALI -->
    <a href="{{ url('/') }}" class="back-button">←</a>

    <div class="container">
        <div class="header">
            <h1>Tunaikan Kewajiban Anda</h1>
            <p>Isi formulir di bawah ini dengan lengkap</p>
        </div>

        <div class="form-card">
            @if(session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

       <form id="zakatForm">
       @csrf


               

                <!-- 1. DATA PRIBADI -->
                <div class="section">
                    <h3>Data Pribadi</h3>

                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama" id="nama" required>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" id="email" required>
                    </div>

                    <div class="form-group">
                        <label>No Telepon *</label>
                        <input type="tel" name="phone" id="phone" required>
                    </div>
                </div>

                <!-- 2. JENIS DONASI -->
                <div class="section">
                    <h3>Jenis Donasi</h3>

                    <div class="form-group">
                        <label>Jenis Zakat *</label>
                        <select name="jenis_zakat" id="jenis_zakat" required>
                            <option value="">-- Pilih --</option>
                            <option value="mal">Zakat Mal</option>
                            <option value="fitrah">Zakat Fitrah</option>
                            <option value="infaq">Infaq / Sedekah</option>
                        </select>
                    </div>

                    <!-- HARTA -->
                    <div class="form-group">
                        <label>Jumlah Harta (Rp)</label>
                        <div class="input-with-button">
                            <input type="text" id="jumlah_harta" name="jumlah_harta" placeholder="Contoh: 10.000.000">
                            <button type="button" id="btn-kalkulator" class="btn-kalkulator">🧮 Kalkulator</button>
                        </div>
                        <small>Isi jika ingin kalkulasi otomatis 2.5% atau gunakan kalkulator</small>
                    </div>

                    <!-- NOMINAL -->
                    <div class="form-group">
                        <label>Jumlah Zakat (Rp) *</label>
                        <input type="text" id="nominal" name="nominal" required placeholder="Minimal Rp 10.000">
                    </div>

                    <div class="form-group">
                        <label>Catatan (opsional)</label>
                        <textarea name="catatan" id="catatan" rows="3"></textarea>
                    </div>
                </div>

           
        <!-- Button -->
        <button type="button" class="btn-submit" id="submit-btn">
            <span id="btn-text">Lanjutkan Pembayaran</span>
            <span id="btn-loading" style="display:none;"><span class="loading"></span></span>
        </button>

        
        <!-- Modal Konfirmasi Pembayaran -->
<div id="confirmation-modal" class="modal">
    <div class="modal-content">
        <h3>Konfirmasi Pembayaran Zakat</h3>
        <div class="modal-body">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><span id="modalNama"></span></td>
                </tr>
                <tr>
                    <td>Jenis Zakat</td>
                    <td>:</td>
                    <td><span id="modalJenis"></span></td>
                </tr>
                <tr>
                    <td>Nominal</td>
                    <td>:</td>
                    <td><span id="modalNominal"></span></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button id="confirmPay" class="btn btn-confirm">Bayar Sekarang</button>
            <button id="cancelPay" class="btn btn-cancel">Batal</button>
        </div>
    </div>
</div>



      <!--  MODAL KALKULATOR!-->
   

    <div id="kalkulatorModal" class="kalkulator-modal">
        <div class="kalkulator-content">
            <div class="kalkulator-header">
                <h2>🧮 Kalkulator Zakat</h2>
                <span id="closeModal" class="close-modal">&times;</span>
            </div>

            <div class="kalkulator-body">

                <div class="zakat-type-selector">
                    <button class="zakat-type-btn active" data-type="penghasilan">Zakat Penghasilan</button>
                    <button class="zakat-type-btn" data-type="maal">Zakat Maal</button>
                </div>

                <input type="hidden" id="jenisZakat" value="penghasilan">

                <!-- PENGHASILAN -->
                <div id="kalkulator-penghasilan" class="kalkulator-page active">
                    <div class="form-group">
                        <label>Penghasilan Bulanan (Rp)</label>
                        <input type="text" id="monthlyIncome">
                    </div>

                    <div class="form-group">
                        <label>Bonus Tahunan (Rp)</label>
                        <input type="text" id="bonusIncome">
                    </div>
                </div>

                <!-- MAAL -->
                <div id="kalkulator-maal" class="kalkulator-page">
                    <div class="form-group">
                        <label>Nilai Emas (Rp)</label>
                        <input type="text" id="emas">
                    </div>

                    <div class="form-group">
                        <label>Uang & Tabungan (Rp)</label>
                        <input type="text" id="uang">
                    </div>

                    <div class="form-group">
                        <label>Aset & Investasi (Rp)</label>
                        <input type="text" id="aset">
                    </div>

                    <div class="form-group">
                        <label>Hutang (Rp)</label>
                        <input type="text" id="hutang">
                    </div>
                </div>

                <!-- ACTION -->
                <div class="kalkulator-actions">
                    <button id="resetKalkulator" class="btn-secondary">Reset</button>
                    <button id="hitungKalkulator" class="btn-primary">Hitung</button>
                </div>

                <!-- HASIL -->
                <div id="hasilSection" class="hasil-section">
                    <h3 id="hasilTitle"></h3>
                    <div class="hasil-amount"><span id="zakatAmount">Rp 0</span></div>

                    <input type="hidden" id="zakatNumeric">

                    <div class="hasil-actions">
                        <button id="gunakanHasil" class="btn-primary">Gunakan</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

       <script src="{{ asset('js/zakat.js') }}"></script>
    </script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}">
</script>


</body>
</html>
