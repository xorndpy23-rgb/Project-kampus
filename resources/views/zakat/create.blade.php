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


                <!-- 3. Pembayaran -->
            <div class="section">
                <h3>💳 Pembayaran</h3>
                <p>Setelah klik tombol <strong>Lanjutkan Pembayaran</strong>, sistem akan membuka halaman pembayaran otomatis melalui Midtrans.</p>
            </div>

                <button type="submit" class="btn-submit" id="submit-btn">
                    <span id="btn-text">Lanjutkan Pembayaran</span>
                    <span id="btn-loading"><span class="loading"></span></span>
                </button>
            </form>

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
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}">
</script>

</body>
</html>
