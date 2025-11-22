// Format Rupiah yang benar dengan format "Rp X.XXX.XXX,–"
function formatRupiah(amount) {
    if (!amount && amount !== 0) return 'Rp 0,–';
    return 'Rp ' + Math.round(amount).toLocaleString('id-ID') + ',–';
}

// Format Rupiah tanpa ",-" untuk detail
function formatRupiahDetail(amount) {
    if (!amount && amount !== 0) return 'Rp 0,–';
    return 'Rp ' + Math.round(amount).toLocaleString('id-ID') + ',–';
}

// Kalkulasi otomatis 2.5% dari jumlah harta
document.getElementById('jumlah_harta').addEventListener('input', function() {
    const jumlahHarta = parseFloat(this.value) || 0;
    if (jumlahHarta > 0) {
        const zakat = jumlahHarta * 0.025;
        document.getElementById('nominal').value = Math.max(Math.round(zakat), 10000);
    }
});

// Pilihan jenis zakat
document.querySelectorAll('.zakat-type-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Reset semua button
        document.querySelectorAll('.zakat-type-btn').forEach(b => {
            b.classList.remove('active');
            b.style.background = 'white';
            b.style.color = '#666';
            b.style.border = '2px solid #E5E7EB';
        });
        
        // Aktifkan button yang dipilih
        this.classList.add('active');
        this.style.background = 'var(--primary)';
        this.style.color = 'white';
        this.style.border = '2px solid var(--primary)';
        
        const zakatType = this.dataset.type;
        document.getElementById('jenisZakat').value = zakatType;
        
        // Tampilkan kalkulator yang sesuai
        document.querySelectorAll('.kalkulator-page').forEach(page => {
            page.classList.remove('active');
        });
        document.getElementById('kalkulator-' + zakatType).classList.add('active');
        
        // Reset hasil kalkulasi
        document.getElementById('hasilSection').style.display = 'none';
        document.getElementById('inputSection').style.display = 'block';
    });
});

// KALKULATOR ZAKAT FUNCTIONALITY
document.getElementById('btn-kalkulator').addEventListener('click', function() {
    document.getElementById('kalkulatorModal').style.display = 'flex';
    // Reset ke input section setiap kali buka modal
    document.getElementById('hasilSection').style.display = 'none';
    document.getElementById('inputSection').style.display = 'block';
});

document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('kalkulatorModal').style.display = 'none';
});

// Tutup modal ketika klik di luar
document.getElementById('kalkulatorModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.style.display = 'none';
    }
});

// Reset kalkulator
document.getElementById('resetKalkulator').addEventListener('click', function() {
    const activeType = document.querySelector('.zakat-type-btn.active').dataset.type;
    
    if (activeType === 'penghasilan') {
        document.getElementById('monthlyIncome').value = '';
        document.getElementById('bonusIncome').value = '';
    } else {
        document.getElementById('emas').value = '';
        document.getElementById('uang').value = '';
        document.getElementById('aset').value = '';
        document.getElementById('hutang').value = '';
    }
});

// Hitung zakat
document.getElementById('hitungKalkulator').addEventListener('click', function() {
    const activeType = document.querySelector('.zakat-type-btn.active').dataset.type;
    let totalHarta = 0;
    
    // Ambil nilai input
    if (activeType === 'penghasilan') {
        const monthlyIncome = parseFloat(document.getElementById('monthlyIncome').value) || 0;
        const bonusIncome = parseFloat(document.getElementById('bonusIncome').value) || 0;
        totalHarta = (monthlyIncome * 12) + bonusIncome;
        
        // Set detail untuk penghasilan
        document.getElementById('detailMonthly').textContent = formatRupiahDetail(monthlyIncome);
        document.getElementById('detailBonus').textContent = formatRupiahDetail(bonusIncome);
        document.getElementById('detailPenghasilan').style.display = 'block';
        document.getElementById('detailMaal').style.display = 'none';
        document.getElementById('hasilTitle').textContent = 'Zakat Penghasilan';
        
    } else {
        const emas = parseFloat(document.getElementById('emas').value) || 0;
        const uang = parseFloat(document.getElementById('uang').value) || 0;
        const aset = parseFloat(document.getElementById('aset').value) || 0;
        const hutang = parseFloat(document.getElementById('hutang').value) || 0;
        totalHarta = emas + uang + aset - hutang;
        
        // Set detail untuk maal
        document.getElementById('detailEmas').textContent = formatRupiahDetail(emas);
        document.getElementById('detailUang').textContent = formatRupiahDetail(uang);
        document.getElementById('detailAset').textContent = formatRupiahDetail(aset);
        document.getElementById('detailHutang').textContent = formatRupiahDetail(hutang);
        document.getElementById('detailPenghasilan').style.display = 'none';
        document.getElementById('detailMaal').style.display = 'block';
        document.getElementById('hasilTitle').textContent = 'Zakat Maal';
    }
    
    const nishab = 85000000; // Rp 85 juta
    
    // Hitung zakat
    let zakatAmount = 0;
    if (totalHarta >= nishab) {
        zakatAmount = totalHarta * 0.025;
    }
    
    // Tampilkan hasil
    document.getElementById('zakatAmount').textContent = formatRupiah(zakatAmount);
    document.getElementById('zakatNumeric').value = zakatAmount;
    
    // Tampilkan hasil section, sembunyikan input section
    document.getElementById('inputSection').style.display = 'none';
    document.getElementById('hasilSection').style.display = 'block';
});

// Gunakan hasil kalkulasi
document.getElementById('gunakanHasil').addEventListener('click', function() {
    const zakatAmount = document.getElementById('zakatNumeric').value;
    const jenisZakat = document.getElementById('jenisZakat').value;
    
    if (zakatAmount && zakatAmount !== '0') {
        document.getElementById('nominal').value = Math.round(zakatAmount);
        
        // Set jenis zakat di form utama
        document.getElementById('jenis_zakat').value = 'mal';
        
        // Set sumber harta berdasarkan jenis zakat
        if (jenisZakat === 'penghasilan') {
            document.getElementById('sumber_harta').value = 'penghasilan';
            const monthlyIncome = parseFloat(document.getElementById('monthlyIncome').value) || 0;
            const bonusIncome = parseFloat(document.getElementById('bonusIncome').value) || 0;
            document.getElementById('jumlah_harta').value = (monthlyIncome * 12) + bonusIncome;
        } else {
            document.getElementById('sumber_harta').value = 'tabungan';
            const emas = parseFloat(document.getElementById('emas').value) || 0;
            const uang = parseFloat(document.getElementById('uang').value) || 0;
            const aset = parseFloat(document.getElementById('aset').value) || 0;
            const hutang = parseFloat(document.getElementById('hutang').value) || 0;
            document.getElementById('jumlah_harta').value = emas + uang + aset - hutang;
        }
    }
    
    document.getElementById('kalkulatorModal').style.display = 'none';
});

// Hitung ulang
document.getElementById('hitungUlang').addEventListener('click', function() {
    document.getElementById('hasilSection').style.display = 'none';
    document.getElementById('inputSection').style.display = 'block';
});

// METODE PEMBAYARAN (tetap sama)
document.querySelectorAll('.method').forEach(method => {
    method.addEventListener('click', function() {
        // Reset semua method
        document.querySelectorAll('.method').forEach(m => m.classList.remove('active'));
        // Aktifkan method yang dipilih
        this.classList.add('active');
        
        const methodType = this.dataset.method;
        document.getElementById('payment_method').value = methodType;
        
        // Tampilkan detail pembayaran
        const paymentDetails = document.getElementById('payment-details');
        paymentDetails.style.display = 'block';
        
        // Sembunyikan semua detail
        document.getElementById('bank-details').style.display = 'none';
        document.getElementById('ewallet-details').style.display = 'none';
        document.getElementById('qris-details').style.display = 'none';
        document.getElementById('cstore-details').style.display = 'none';
        
        // Tampilkan detail yang sesuai
        if (methodType === 'bank_transfer') {
            document.getElementById('bank-details').style.display = 'block';
        } else if (methodType === 'ewallet') {
            document.getElementById('ewallet-details').style.display = 'block';
        } else if (methodType === 'qris') {
            document.getElementById('qris-details').style.display = 'block';
        } else if (methodType === 'cstore') {
            document.getElementById('cstore-details').style.display = 'block';
            // Generate random payment code untuk Alfamart/Indomaret
            document.getElementById('payment-code').textContent = 'ALFA' + Math.random().toString(36).substr(2, 8).toUpperCase();
        }
    });
});

// Validasi form sebelum submit
document.getElementById('zakatForm').addEventListener('submit', function(e) {
    const nominal = parseFloat(document.getElementById('nominal').value) || 0;
    const paymentMethod = document.getElementById('payment_method').value;
    
    if (nominal < 10000) {
        e.preventDefault();
        alert('Nominal minimal Rp 10,000');
        document.getElementById('nominal').focus();
        return;
    }
    
    if (!paymentMethod) {
        e.preventDefault();
        alert('Silakan pilih metode pembayaran terlebih dahulu');
        return;
    }
    
    // Tampilkan loading
    document.getElementById('btn-text').style.display = 'none';
    document.getElementById('btn-loading').style.display = 'inline';
    document.getElementById('submit-btn').disabled = true;
});