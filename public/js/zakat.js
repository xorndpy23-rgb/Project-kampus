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

// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements
    initializeKalkulator();
    initializePaymentMethods();
    initializeFormValidation();
});

// KALKULATOR FUNCTIONALITY
function initializeKalkulator() {
    const jumlahHartaInput = document.getElementById('jumlah_harta');
    const nominalInput = document.getElementById('nominal');
    const btnKalkulator = document.getElementById('btn-kalkulator');
    const kalkulatorModal = document.getElementById('kalkulatorModal');
    const closeModal = document.getElementById('closeModal');
    
    if (!jumlahHartaInput || !nominalInput || !btnKalkulator) return;

    // Kalkulasi otomatis 2.5% dari jumlah harta
    jumlahHartaInput.addEventListener('input', function() {
        const jumlahHarta = parseFloat(this.value) || 0;
        if (jumlahHarta > 0) {
            const zakat = jumlahHarta * 0.025;
            nominalInput.value = Math.max(Math.round(zakat), 10000);
        }
    });

    // Buka modal kalkulator
    btnKalkulator.addEventListener('click', function() {
        kalkulatorModal.style.display = 'flex';
        // Reset ke input section setiap kali buka modal
        document.getElementById('hasilSection').style.display = 'none';
        document.getElementById('inputSection').style.display = 'block';
    });

    // Tutup modal
    closeModal.addEventListener('click', function() {
        kalkulatorModal.style.display = 'none';
    });

    // Tutup modal ketika klik di luar
    kalkulatorModal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });

    // Pilihan jenis zakat dalam kalkulator
    document.querySelectorAll('.zakat-type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Reset semua button
            document.querySelectorAll('.zakat-type-btn').forEach(b => {
                b.classList.remove('active');
            });
            
            // Aktifkan button yang dipilih
            this.classList.add('active');
            
            const zakatType = this.dataset.type;
            document.getElementById('jenisZakat').value = zakatType;
            
            // Tampilkan kalkulator yang sesuai
            document.querySelectorAll('.kalkulator-page').forEach(page => {
                page.classList.remove('active');
            });
            document.getElementById('kalkulator-' + zakatType).classList.add('active');
            
            // Reset hasil kalkulasi
            document.getElementById('hasilSection').style.display = 'none';
        });
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
        
        document.getElementById('hasilSection').style.display = 'none';
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
        
        // Tampilkan hasil section
        document.getElementById('hasilSection').style.display = 'block';
    });

    // Gunakan hasil kalkulasi
    document.getElementById('gunakanHasil').addEventListener('click', function() {
        const zakatAmount = document.getElementById('zakatNumeric').value;
        const jenisZakat = document.getElementById('jenisZakat').value;
        
        if (zakatAmount && zakatAmount !== '0') {
            nominalInput.value = Math.round(zakatAmount);
            
            // Set jenis zakat di form utama
            document.getElementById('jenis_zakat').value = 'mal';
            
            // Set sumber harta berdasarkan jenis zakat
            if (jenisZakat === 'penghasilan') {
                document.getElementById('sumber_harta').value = 'penghasilan';
                const monthlyIncome = parseFloat(document.getElementById('monthlyIncome').value) || 0;
                const bonusIncome = parseFloat(document.getElementById('bonusIncome').value) || 0;
                jumlahHartaInput.value = (monthlyIncome * 12) + bonusIncome;
            } else {
                document.getElementById('sumber_harta').value = 'tabungan';
                const emas = parseFloat(document.getElementById('emas').value) || 0;
                const uang = parseFloat(document.getElementById('uang').value) || 0;
                const aset = parseFloat(document.getElementById('aset').value) || 0;
                const hutang = parseFloat(document.getElementById('hutang').value) || 0;
                jumlahHartaInput.value = emas + uang + aset - hutang;
            }
        }
        
        kalkulatorModal.style.display = 'none';
    });

    // Hitung ulang
    document.getElementById('hitungUlang').addEventListener('click', function() {
        document.getElementById('hasilSection').style.display = 'none';
    });
}

// PAYMENT METHODS FUNCTIONALITY
function initializePaymentMethods() {
    const paymentMethods = document.querySelectorAll('.method');
    const paymentMethodInput = document.getElementById('payment_method');
    const paymentDetails = document.getElementById('payment-details');

    if (!paymentMethods.length || !paymentMethodInput || !paymentDetails) return;

    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            // Reset semua method
            paymentMethods.forEach(m => m.classList.remove('active'));
            
            // Aktifkan method yang dipilih
            this.classList.add('active');
            
            const methodType = this.dataset.method;
            paymentMethodInput.value = methodType;
            
            // Tampilkan detail pembayaran
            paymentDetails.style.display = 'block';
            
            // Sembunyikan semua detail
            document.querySelectorAll('.method-details').forEach(detail => {
                detail.style.display = 'none';
            });
            
            // Tampilkan detail yang sesuai
            if (methodType === 'bank_transfer') {
                document.getElementById('bank_transfer-details').style.display = 'block';
                // Reset pilihan bank
                document.querySelectorAll('.bank-option').forEach(opt => opt.classList.remove('active'));
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

    // Pilihan bank dalam transfer bank
    document.querySelectorAll('.bank-option').forEach(option => {
        option.addEventListener('click', function() {
            // Reset semua bank option
            document.querySelectorAll('.bank-option').forEach(opt => opt.classList.remove('active'));
            // Aktifkan bank yang dipilih
            this.classList.add('active');
            // Update payment_method value dengan bank yang dipilih
            const bank = this.dataset.bank;
            paymentMethodInput.value = bank;
        });
    });
   // --- E-WALLET SELECTION FIX (tanpa overwrite HTML existing) ---
document.querySelectorAll('.ewallet-option').forEach(item => {
    item.addEventListener('click', () => {

        // reset active class
        document.querySelectorAll('.ewallet-option').forEach(opt => opt.classList.remove('selected'));

        // add active class
        item.classList.add('selected');

        // set value to hidden input
        document.getElementById("payment_method").value = "ewallet_" + item.dataset.ewallet;
    });
});

    // Jika sudah ada nilai old untuk payment_method, set aktif
    const oldPaymentMethod = paymentMethodInput.value;
    if (oldPaymentMethod) {
        // Cari method yang sesuai dan klik
        document.querySelector(`.method[data-method="${oldPaymentMethod}"]`)?.click();
        
        // Jika oldPaymentMethod adalah bank, maka cari bank option yang sesuai
        if (['bca', 'bri', 'mandiri'].includes(oldPaymentMethod)) {
            document.querySelector(`.bank-option[data-bank="${oldPaymentMethod}"]`)?.click();
        }
    }
}

// FORM VALIDATION
function initializeFormValidation() {
    const zakatForm = document.getElementById('zakatForm');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');

    if (!zakatForm || !submitBtn) return;

    zakatForm.addEventListener('submit', function(e) {
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
        if (btnText && btnLoading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        }
        submitBtn.disabled = true;
    });
}

// Helper function untuk menampilkan pesan error
function showError(inputId, message) {
    const input = document.getElementById(inputId);
    const errorDiv = document.getElementById(inputId + '-error');
    
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
    }
    
    if (input) {
        input.style.borderColor = 'var(--error)';
    }
}

// Helper function untuk menghapus pesan error
function clearError(inputId) {
    const input = document.getElementById(inputId);
    const errorDiv = document.getElementById(inputId + '-error');
    
    if (errorDiv) {
        errorDiv.style.display = 'none';
    }
    
    if (input) {
        input.style.borderColor = 'var(--border)';
    }
}
// --- PAYMENT SELECTION FIX SCRIPT (TARUH PALING BAWAH FILE) ---

document.addEventListener("DOMContentLoaded", function () {

    // BANK SELECTION
    document.querySelectorAll('.bank-option').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.bank-option').forEach(opt => opt.classList.remove('selected'));
            btn.classList.add('selected');

            document.getElementById('selectedBankInput').value = btn.dataset.bank;
            document.getElementById('payment_method').value = "bank_transfer";
        });
    });

    // EWALLET SELECTION
    document.querySelectorAll('.ewallet-option').forEach(option => {
        option.addEventListener('click', () => {
            document.querySelectorAll('.ewallet-option').forEach(el => el.classList.remove('selected'));
            option.classList.add('selected');

            document.getElementById('selectedEwalletInput').value = option.dataset.ewallet;
            document.getElementById('payment_method').value = "ewallet";
        });
    });

});
document.querySelectorAll('.ewallet-option').forEach(option => {
    option.addEventListener('click', () => {
        document.querySelectorAll('.ewallet-option').forEach(el => el.classList.remove('selected'));

        option.classList.add('selected');

        document.getElementById('payment_method').value = "ewallet_" + option.dataset.ewallet;
    });
});
