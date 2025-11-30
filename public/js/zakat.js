// Format Rupiah dengan format "Rp X.XXX.XXX,–"
function formatRupiah(amount) {
    if (!amount && amount !== 0) return 'Rp 0,–';
    return 'Rp ' + Math.round(amount).toLocaleString('id-ID') + ',–';
}

// Format Rupiah detail
function formatRupiahDetail(amount) {
    if (!amount && amount !== 0) return 'Rp 0,–';
    return 'Rp ' + Math.round(amount).toLocaleString('id-ID') + ',–';
}

// DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    initializeKalkulator();
    initializeFormValidation();
});

/* ==============================
   KALKULATOR ZAKAT
============================== */

function initializeKalkulator() {
    const jumlahHartaInput = document.getElementById('jumlah_harta');
    const nominalInput = document.getElementById('nominal');
    const btnKalkulator = document.getElementById('btn-kalkulator');
    const kalkulatorModal = document.getElementById('kalkulatorModal');
    const closeModal = document.getElementById('closeModal');

    if (!jumlahHartaInput || !nominalInput || !btnKalkulator) return;

    jumlahHartaInput.addEventListener('input', function() {
        const jumlahHarta = parseFloat(this.value) || 0;
        if (jumlahHarta > 0) {
            const zakat = jumlahHarta * 0.025;
            nominalInput.value = Math.max(Math.round(zakat), 10000);
        }
    });

    btnKalkulator.addEventListener('click', function() {
        kalkulatorModal.style.display = 'flex';
        document.getElementById('hasilSection').style.display = 'none';
        document.getElementById('inputSection').style.display = 'block';
    });

    closeModal.addEventListener('click', function() {
        kalkulatorModal.style.display = 'none';
    });

    kalkulatorModal.addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });

    // Pilihan zakat
    document.querySelectorAll('.zakat-type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.zakat-type-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const type = this.dataset.type;
            document.getElementById('jenisZakat').value = type;

            document.querySelectorAll('.kalkulator-page').forEach(p => p.classList.remove('active'));
            document.getElementById('kalkulator-' + type).classList.add('active');

            document.getElementById('hasilSection').style.display = 'none';
        });
    });

    // Reset kalkulator
    document.getElementById('resetKalkulator').addEventListener('click', function() {
        const type = document.querySelector('.zakat-type-btn.active').dataset.type;

        if (type === 'penghasilan') {
            document.getElementById('monthlyIncome').value = '';
            document.getElementById('bonusIncome').value = '';
        } else {
            ['emas','uang','aset','hutang'].forEach(id => document.getElementById(id).value = '');
        }

        document.getElementById('hasilSection').style.display = 'none';
    });

    // Hitung zakat
    document.getElementById('hitungKalkulator').addEventListener('click', function() {
        const type = document.querySelector('.zakat-type-btn.active').dataset.type;
        let totalHarta = 0;

        if (type === 'penghasilan') {
            const monthly = parseFloat(document.getElementById('monthlyIncome').value) || 0;
            const bonus = parseFloat(document.getElementById('bonusIncome').value) || 0;

            totalHarta = (monthly * 12) + bonus;
            document.getElementById('detailMonthly').textContent = formatRupiahDetail(monthly);
            document.getElementById('detailBonus').textContent = formatRupiahDetail(bonus);

            document.getElementById('detailPenghasilan').style.display = 'block';
            document.getElementById('detailMaal').style.display = 'none';
            document.getElementById('hasilTitle').textContent = 'Zakat Penghasilan';

        } else {
            const emas   = parseFloat(document.getElementById('emas').value) || 0;
            const uang   = parseFloat(document.getElementById('uang').value) || 0;
            const aset   = parseFloat(document.getElementById('aset').value) || 0;
            const hutang = parseFloat(document.getElementById('hutang').value) || 0;

            totalHarta = emas + uang + aset - hutang;

            document.getElementById('detailEmas').textContent = formatRupiahDetail(emas);
            document.getElementById('detailUang').textContent = formatRupiahDetail(uang);
            document.getElementById('detailAset').textContent = formatRupiahDetail(aset);
            document.getElementById('detailHutang').textContent = formatRupiahDetail(hutang);

            document.getElementById('detailPenghasilan').style.display = 'none';
            document.getElementById('detailMaal').style.display = 'block';
            document.getElementById('hasilTitle').textContent = 'Zakat Maal';
        }

        const nishab = 85000000;
        const zakatAmount = totalHarta >= nishab ? totalHarta * 0.025 : 0;

        document.getElementById('zakatAmount').textContent = formatRupiah(zakatAmount);
        document.getElementById('zakatNumeric').value = zakatAmount;

        document.getElementById('hasilSection').style.display = 'block';
    });

    // Gunakan hasil
    document.getElementById('gunakanHasil').addEventListener('click', function() {
        const zakatAmount = document.getElementById('zakatNumeric').value;

        if (zakatAmount && zakatAmount !== '0') {
            nominalInput.value = Math.round(zakatAmount);
        }

        kalkulatorModal.style.display = 'none';
    });
}

/* ==============================
   FORM VALIDATION 
============================== */

function initializeFormValidation() {
    const zakatForm = document.getElementById('zakatForm');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');

    if (!zakatForm || !submitBtn) return;

    zakatForm.addEventListener('submit', function(e) {
        const nominal = parseFloat(document.getElementById('nominal').value) || 0;

        if (nominal < 10000) {
            e.preventDefault();
            alert('Nominal minimal Rp 10.000');
            return;
        }

        if (btnText && btnLoading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        }

        submitBtn.disabled = true;
    });
}
