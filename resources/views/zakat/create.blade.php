<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Zakat - Masjid Al-Muttaqin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- TOMBOL KEMBALI -->
    <a href="{{ url('/') }}" class="back-button" title="Kembali ke Beranda">←</a>
    <body class="create-page">
    <div class="container">
        <div class="header">
            <h1>Tunaikan Kewajiban Anda</h1>
            <p>Isi formulir di bawah ini dengan lengkap</p>
        </div>

        <div class="form-card">
            @if(session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            <form action="{{ route('zakat.store') }}" method="POST" id="zakatForm">
                @csrf

                <!-- 1. Data Pribadi -->
                <div class="section">
                    <h3> Data Pribadi</h3>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="nama" name="nama" required value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="contoh@email.com">
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor Telepon/WhatsApp <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <!-- 2. Jenis Donasi -->
                <div class="section">
                    <h3> Jenis Donasi</h3>
                    <div class="form-group">
                        <label for="jenis_zakat">Jenis Zakat <span class="required">*</span></label>
                        <select id="jenis_zakat" name="jenis_zakat" required>
                            <option value="">-- Pilih Jenis Zakat --</option>
                            <option value="mal" {{ old('jenis_zakat') == 'mal' ? 'selected' : '' }}>Zakat Mal (Harta)</option>
                            <option value="fitrah" {{ old('jenis_zakat') == 'fitrah' ? 'selected' : '' }}>Zakat Fitrah</option>
                            <option value="infaq" {{ old('jenis_zakat') == 'infaq' ? 'selected' : '' }}>Infaq / Sedekah</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sumber_harta">Sumber Harta yang Dizakati</label>
                        <select id="sumber_harta" name="sumber_harta">
                            <option value="">-- Pilih Sumber Harta --</option>
                            <option value="penghasilan" {{ old('sumber_harta') == 'penghasilan' ? 'selected' : '' }}>Penghasilan</option>
                            <option value="tabungan" {{ old('sumber_harta') == 'tabungan' ? 'selected' : '' }}>Tabungan</option>
                            <option value="perdagangan" {{ old('sumber_harta') == 'perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                            <option value="pertanian" {{ old('sumber_harta') == 'pertanian' ? 'selected' : '' }}>Pertanian</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_harta">Jumlah Harta (Rupiah)</label>
                        <div class="input-with-button">
                            <input type="number" id="jumlah_harta" name="jumlah_harta" value="{{ old('jumlah_harta') }}" placeholder="Contoh: 10000000">
                            <button type="button" id="btn-kalkulator" class="btn-kalkulator">🧮 Kalkulator</button>
                        </div>
                        <small>Isi jika ingin kalkulasi otomatis 2.5% atau gunakan kalkulator</small>
                    </div>

                    <div class="form-group">
                        <label for="nominal">Jumlah Zakat yang Harus Dibayarkan (Rupiah) <span class="required">*</span></label>
                        <input type="number" id="nominal" name="nominal" required min="10000" value="{{ old('nominal') }}" placeholder="Minimal Rp 10,000">
                        <small>Minimal Rp 10,000</small>
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan Zakat/Infaq (Opsional)</label>
                        <textarea id="catatan" name="catatan" rows="3" placeholder="">{{ old('catatan') }}</textarea>
                    </div>
                </div>

                <!-- 3. Metode Pembayaran -->
                <div class="section">
                    <h3>💳 Metode Pembayaran</h3>
                    <p>Pilih metode pembayaran yang diinginkan:</p>
                    <div class="payment-methods">
                        <div class="method" data-method="bank_transfer"><div>🏦</div><small>Transfer Bank</small></div>
                        <div class="method" data-method="ewallet"><div>📱</div><small>E-Wallet</small></div>
                        <div class="method" data-method="qris"><div></div><small>QRIS</small></div>
                        <div class="method" data-method="cstore"><div></div><small>Alfamart/Indomaret</small></div>
                    </div>

                    <input type="hidden" id="payment_method" name="payment_method" value="{{ old('payment_method') }}">
                    
                    <div id="payment-details" class="payment-details">

    <!-- BANK TRANSFER -->
    <div id="bank_transfer-details" class="method-details">
        <h4>Pilih Bank Tujuan</h4>

        <div class="bank-options">
            <div class="bank-option" data-bank="bca">
                <div class="bank-logo">
                    <img src="{{ asset('assets/img/bca.png') }}" alt="Bank BCA">
                </div>
                <div class="bank-info">
                    <strong>Bank BCA</strong>
                    <p>1234567890</p>
                    <p>Masjid Al-Muttaqin</p>
                </div>
            </div>

            <div class="bank-option" data-bank="bri">
                <div class="bank-logo">
                    <img src="{{ asset('assets/img/bri.png') }}" alt="Bank BRI">
                </div>
                <div class="bank-info">
                    <strong>Bank BRI</strong>
                    <p>0987654321</p>
                    <p>Masjid Al-Muttaqin</p>
                </div>
            </div>

            <div class="bank-option" data-bank="mandiri">
                <div class="bank-logo">
                    <img src="{{ asset('assets/img/mandiri.png') }}" alt="Bank Mandiri">
                </div>
                <div class="bank-info">
                    <strong>Bank Mandiri</strong>
                    <p>1122334455</p>
                    <p>Masjid Al-Muttaqin</p>
                </div>
            </div>
        </div>
    </div>

           <!-- E-WALLET -->
<div id="ewallet-details" class="method-details" style="display:none;">
    <h4>Pilih E-Wallet</h4>
    <div class="bank-options">

        <div class="bank-option ewallet-option" data-ewallet="gopay">
            <div class="bank-logo"><img src="{{ asset('assets/img/gopay.jpg') }}" alt="Gopay"></div>
            <div class="bank-info">
                <strong>Gopay</strong>
                <p>081234567890</p>
                <p>a.n Masjid Al-Muttaqin</p>
            </div>
        </div>

        <div class="bank-option ewallet-option" data-ewallet="ovo">
            <div class="bank-logo"><img src="{{ asset('assets/img/ovo.png') }}" alt="OVO"></div>
            <div class="bank-info">
                <strong>OVO</strong>
                <p>081234567890</p>
                <p>a.n Masjid Al-Muttaqin</p>
            </div>
        </div>

        <div class="bank-option ewallet-option" data-ewallet="dana">
            <div class="bank-logo"><img src="{{ asset('assets/img/dana.png') }}" alt="Dana"></div>
            <div class="bank-info">
                <strong>DANA</strong>
                <p>081234567890</p>
                <p>a.n Masjid Al-Muttaqin</p>
            </div>
        </div>

        <div class="bank-option ewallet-option" data-ewallet="shopeepay">
            <div class="bank-logo"><img src="{{ asset('assets/img/shopeepay.png') }}" alt="ShopeePay"></div>
            <div class="bank-info">
                <strong>ShopeePay</strong>
                <p>081234567890</p>
                <p>a.n Masjid Al-Muttaqin</p>
            </div>
        </div>
    </div>
</div>


    <!-- QRIS -->
    <div id="qris-details" class="method-details">
        <h4>QRIS</h4>
        <p>Scan kode QR berikut:</p>

        <div class="qris-container">
            <div class="qris-code">
                <img src="{{ asset('assets/img/qr.jpeg') }}" alt="QRIS" class="qr-image" onerror="handleQRError(this)">
            </div>

            <div id="qr-fallback" style="display:none; text-align:center; margin-top:10px;">
                <p>QR Code tidak tersedia, silakan transfer manual.</p>
            </div>
        </div>
    </div>

    <!-- CSTORE -->
    <div id="cstore-details" class="method-details">
        <h4>Alfamart / Indomaret</h4>
        <p>Kode Pembayaran:</p>
        <div class="payment-code"><strong>ALFA123456</strong></div>
    </div>

</div>

<!-- Hidden untuk dikirim ke controller -->
<input type="hidden" id="selectedBankInput" name="selected_bank">
<input type="hidden" id="selectedEwalletInput" name="selected_ewallet">

                        <div id="cstore-details" class="method-details">
                            <h4>Alfamart/Indomaret</h4>
                            <p>Gunakan kode pembayaran berikut:</p>
                            <div class="payment-code"><strong id="payment-code">ALFA123456</strong></div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="submit-btn">
                    <span id="btn-text">Lanjutkan Pembayaran</span>
                    <span id="btn-loading"><span class="loading"></span></span>
                </button>
            </form>

            @if($errors->any())
                <div class="error-container">
                    <h4>❌ Terjadi kesalahan:</h4>
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
        </div>
    </div>

    <!-- MODAL KALKULATOR -->
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

                <div id="kalkulator-penghasilan" class="kalkulator-page active">
                    <div class="form-group"><label>Penghasilan Bulanan (Rp)</label><input type="number" id="monthlyIncome"></div>
                    <div class="form-group"><label>Bonus/Tunjangan Tahunan (Rp)</label><input type="number" id="bonusIncome"></div>
                </div>

                <div id="kalkulator-maal" class="kalkulator-page">
                    <div class="form-group"><label>Nilai Emas & Perak (Rp)</label><input type="number" id="emas"></div>
                    <div class="form-group"><label>Uang Tunai & Tabungan (Rp)</label><input type="number" id="uang"></div>
                    <div class="form-group"><label>Nilai Aset & Investasi (Rp)</label><input type="number" id="aset"></div>
                    <div class="form-group"><label>Hutang Jangka Pendek (Rp)</label><input type="number" id="hutang"></div>
                </div>

                <div class="kalkulator-actions">
                    <button type="button" id="resetKalkulator" class="btn-secondary">Reset</button>
                    <button type="button" id="hitungKalkulator" class="btn-primary">Hitung Zakat</button>
                </div>

                <div id="hasilSection" class="hasil-section">
                    <h3 id="hasilTitle">Zakat Penghasilan</h3>
                    <div class="hasil-amount"><span id="zakatAmount">Rp 0,–</span></div>
                    <div id="detailPenghasilan" class="hasil-details">
                        <p><strong>Detail Penghasilan:</strong></p>
                        <p>Penghasilan Bulanan: <span id="detailMonthly">Rp 0,–</span></p>
                        <p>Bonus Tahunan: <span id="detailBonus">Rp 0,–</span></p>
                    </div>
                    <div id="detailMaal" class="hasil-details">
                        <p><strong>Detail Harta:</strong></p>
                        <p>Emas & Perak: <span id="detailEmas">Rp 0,–</span></p>
                        <p>Uang & Tabungan: <span id="detailUang">Rp 0,–</span></p>
                        <p>Aset & Investasi: <span id="detailAset">Rp 0,–</span></p>
                        <p>Hutang: <span id="detailHutang">Rp 0,–</span></p>
                    </div>
                    <input type="hidden" id="zakatNumeric" value="0">
                    <div class="hasil-actions">
                        <button type="button" id="hitungUlang" class="btn-secondary">Hitung Ulang</button>
                        <button type="button" id="gunakanHasil" class="btn-primary">Gunakan Hasil</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/zakat.js') }}"></script>
    <script>
        function handleQRError(img) {
            img.style.display = 'none';
            document.getElementById('qr-fallback').style.display = 'block';
        }
    </script>
</body>
</html>
