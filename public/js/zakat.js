// ======================================================
// FORMAT RUPIAH & HELPERS
// ======================================================
function formatRupiah(angka) {
    if (!angka) return "Rp 0";
    const number = parseInt(String(angka).replace(/\D/g, "")) || 0;
    return "Rp " + number.toLocaleString("id-ID");
}

function getNumeric(value) {
    if (!value) return 0;
    return parseInt(String(value).replace(/\D/g, "")) || 0;
}

function applyRupiahFormat(input) {
    if (!input) return;
    input.addEventListener("input", function () {
        let val = this.value.replace(/\D/g, "");
        this.value = val ? formatRupiah(val) : "";
    });
}

function baznasRound(n) {
    return Math.ceil(n / 2500) * 2500;
}

// ======================================================
// ELEMENTS
// ======================================================
const modal = document.getElementById("kalkulatorModal");
const btnKalkulator = document.getElementById("btn-kalkulator");
const closeModal = document.getElementById("closeModal");
const hitungBtn = document.getElementById("hitungKalkulator");
const resetBtn = document.getElementById("resetKalkulator");
const gunakanBtn = document.getElementById("gunakanHasil");

const jenisZakatInput = document.getElementById("jenisZakat");
const pagePenghasilan = document.getElementById("kalkulator-penghasilan");
const pageMaal = document.getElementById("kalkulator-maal");

const monthlyIncome = document.getElementById("monthlyIncome");
const bonusIncome = document.getElementById("bonusIncome");

const emas = document.getElementById("emas");
const uang = document.getElementById("uang");
const aset = document.getElementById("aset");
const hutang = document.getElementById("hutang");

const hasilSection = document.getElementById("hasilSection");
const zakatAmount = document.getElementById("zakatAmount");
const zakatNumeric = document.getElementById("zakatNumeric");

const jumlahHarta = document.getElementById("jumlah_harta");
const nominal = document.getElementById("nominal");

const hasilTitle = document.getElementById("hasilTitle");

const submitBtn = document.getElementById("submit-btn");

// ======================================================
// MODAL KALKULATOR
// ======================================================
if (btnKalkulator) {
    btnKalkulator.addEventListener("click", () => {
        modal.style.display = "flex";
        hasilSection.style.display = "none";
        zakatNumeric.value = "";
    });
}

if (closeModal) {
    closeModal.addEventListener("click", () => modal.style.display = "none");
}

window.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
});

document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") modal.style.display = "none";
});

// ======================================================
// SWITCH PAGE ZAKAT
// ======================================================
document.querySelectorAll(".zakat-type-btn").forEach(btn => {
    btn.addEventListener("click", function () {
        document.querySelectorAll(".zakat-type-btn").forEach(b => b.classList.remove("active"));
        this.classList.add("active");

        const tipe = this.dataset.type;
        jenisZakatInput.value = tipe;

        pagePenghasilan.classList.toggle("active", tipe === "penghasilan");
        pageMaal.classList.toggle("active", tipe === "maal");

        hasilSection.style.display = "none";
    });
});

// ======================================================
// APPLY FORMAT RUPIAH
// ======================================================
[monthlyIncome, bonusIncome, emas, uang, aset, hutang, jumlahHarta, nominal].forEach(input => {
    applyRupiahFormat(input);
});

// ======================================================
// HITUNG ZAKAT
// ======================================================
if (hitungBtn) {
    hitungBtn.addEventListener("click", () => {
        let hasil = 0;

        if (jenisZakatInput.value === "penghasilan") {
            const gaji = getNumeric(monthlyIncome.value);
            const bonus = getNumeric(bonusIncome.value);
            const totalPerBulan = gaji + (bonus / 12);
            hasil = baznasRound(totalPerBulan * 0.025);
            hasilTitle.textContent = "Jumlah Zakat Penghasilan Anda";
        } else {
            const vEmas = getNumeric(emas.value);
            const vUang = getNumeric(uang.value);
            const vAset = getNumeric(aset.value);
            const vHutang = getNumeric(hutang.value);

            const total = vEmas + vUang + vAset - vHutang;
            const hargaEmas = 1200000;
            const nisab = 85 * hargaEmas;

            if (total < nisab) {
                hasilTitle.textContent = "Harta Anda Belum Mencapai Nisab";
                zakatAmount.textContent = "Rp 0";
                zakatNumeric.value = 0;
                hasilSection.style.display = "block";
                return;
            }

            hasil = baznasRound(total * 0.025);
            hasilTitle.textContent = "Jumlah Zakat Maal Anda";
        }

        zakatAmount.textContent = formatRupiah(hasil);
        zakatNumeric.value = hasil;
        hasilSection.style.display = "block";
    });
}

// ======================================================
// RESET KALKULATOR
// ======================================================
if (resetBtn) {
    resetBtn.addEventListener("click", () => {
        [monthlyIncome, bonusIncome, emas, uang, aset, hutang].forEach(i => i.value = "");
        hasilSection.style.display = "none";
    });
}

// ======================================================
// GUNAKAN HASIL KALKULATOR
// ======================================================
if (gunakanBtn) {
    gunakanBtn.addEventListener("click", () => {
        const nilai = parseInt(zakatNumeric.value);
        if (nilai > 0) {
            nominal.value = formatRupiah(nilai);
            jumlahHarta.value = "";
        }
        modal.style.display = "none";
    });
}

// ======================================================
// MODAL KONFIRMASI PEMBAYARAN (BAZNAS STYLE)
// ======================================================
const confirmModal = document.getElementById("confirmation-modal");
const modalNama = document.getElementById("modalNama");
const modalJenis = document.getElementById("modalJenis");
const modalNominal = document.getElementById("modalNominal");
const confirmBtn = document.getElementById("confirmPay");
const cancelBtn = document.getElementById("cancelPay");

function showModal() { confirmModal.classList.add("show"); }
function hideModal() { confirmModal.classList.remove("show"); }

if(cancelBtn){
    cancelBtn.addEventListener("click", hideModal);
}

window.addEventListener("click", (e) => {
    if(e.target === confirmModal) hideModal();
});

// ======================================================
// OVERRIDE TOMBOL SUBMIT
// ======================================================
if(submitBtn){
    submitBtn.addEventListener("click", function(e){
        e.preventDefault();

        const requiredFields = [
            { el: document.getElementById("nama"), msg: "Silakan isi nama dulu!" },
            { el: document.getElementById("email"), msg: "Silakan isi email dulu!" },
            { el: document.getElementById("phone"), msg: "Silakan isi nomor telepon dulu!" },
            { el: document.getElementById("jenis_zakat"), msg: "Silakan pilih jenis zakat dulu!" },
            { el: nominal, msg: "Silakan isi nominal dulu!" }
        ];

        for(let field of requiredFields){
            if(!field.el) continue;
            const value = field.el.tagName === "SELECT" ? field.el.value : field.el.value.trim();
            if(!value || (field.el === nominal && getNumeric(field.el.value)<=0)){
                alert(field.msg);
                field.el.focus();
                return;
            }
        }

        if(getNumeric(nominal.value)<10000){
            alert("Minimal pembayaran Rp 10.000");
            nominal.focus();
            return;
        }

        // Set data ke modal
        modalNama.textContent = document.getElementById("nama").value.trim();
        modalJenis.textContent = document.getElementById("jenis_zakat").value;
        modalNominal.textContent = nominal.value;

        showModal();

        confirmBtn.onclick = function(){
            submitBtn.disabled = true;
            document.getElementById("btn-text").style.display = "none";
            document.getElementById("btn-loading").style.display = "inline-flex";

            fetch("/zakat/midtrans", {
                method:"POST",
                headers:{
                    "Content-Type":"application/json",
                    "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    nama: document.getElementById("nama").value.trim(),
                    email: document.getElementById("email").value.trim(),
                    phone: document.getElementById("phone").value.trim(),
                    jenis_zakat: document.getElementById("jenis_zakat").value,
                    nominal: getNumeric(nominal.value)
                })
            })
            .then(res=>res.json())
            .then(data=>{
                submitBtn.disabled=false;
                document.getElementById("btn-text").style.display="inline";
                document.getElementById("btn-loading").style.display="none";

                if(!data.snap_token){ 
                    alert("Gagal mendapatkan token pembayaran"); 
                    return; 
                }

                // Tutup modal setelah snap muncul
                hideModal();

                // Panggil snap.pay langsung, aman karena dipanggil di handler click
                snap.pay(data.snap_token,{
                    onSuccess:()=>window.location.href=`/zakat/success/${data.order_id}`,
                    onPending:()=>window.location.href=`/zakat/pending/${data.order_id}`,
                    onError:()=>alert("Pembayaran gagal")
                });
            })
            .catch(err=>{
                submitBtn.disabled=false;
                document.getElementById("btn-text").style.display="inline";
                document.getElementById("btn-loading").style.display="none";
                alert("Server error");
                console.error(err);
            });
        };
    });
}
