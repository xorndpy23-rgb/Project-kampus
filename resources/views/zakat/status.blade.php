<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek Status Transaksi | Masjid Al-Muttaqin</title>

    <!-- Memuat Tailwind CSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Konfigurasi warna yang konsisten */
        :root {
            --color-primary: #10B981; /* Green 500 */
            --color-primary-dark: #059669; /* Green 600 */
        }
        .bg-primary { background-color: var(--color-primary); }
        .text-primary { color: var(--color-primary); }
        .border-primary { border-color: var(--color-primary); }
        .hover\:bg-primary-dark:hover { background-color: var(--color-primary-dark); }
        
        /* Status Colors */
        .status-verified { @apply bg-green-100 text-green-700 border-green-400; }
        .status-pending { @apply bg-yellow-100 text-yellow-700 border-yellow-400; }
        .status-rejected { @apply bg-red-100 text-red-700 border-red-400; }
    </style>
</head>
<body class="antialiased bg-gray-100 text-gray-800">

    <div class="relative min-h-screen flex items-center justify-center py-10 px-4">
        
        <!-- Kontainer Utama -->
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-2xl p-8 md:p-10">
            
            <div class="text-3xl text-center text-primary mb-4">🔍</div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2 text-center">
                Cek Status Donasi & Zakat
            </h1>
            <p class="text-gray-600 mb-8 text-center">
                Masukkan Kode Transaksi yang Anda dapatkan di halaman konfirmasi.
            </p>

            <!-- Form Pencarian Kode Transaksi -->
            <div class="flex space-x-2 mb-8">
                <input type="text" id="kode_transaksi_input" 
                    placeholder="Contoh: MUTTAQIN-PENDING"
                    class="flex-grow border border-gray-300 rounded-lg p-3 text-lg focus:ring-primary focus:border-primary uppercase">
                
                <button type="button" onclick="checkStatus()" 
                        class="flex-shrink-0 px-6 py-3 text-lg font-bold rounded-lg text-white bg-primary hover:bg-primary-dark transition duration-200 focus:ring-4 focus:ring-primary/50">
                    Cek Status
                </button>
            </div>

            <!-- Area Hasil Status (Hidden by default) -->
            <div id="status_result" class="hidden">
                <h2 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Hasil Pencarian Transaksi</h2>

                <!-- Kartu Status Dinamis -->
                <div id="status_card" class="p-6 rounded-xl border-l-4 shadow-md transition-colors duration-300">
                    <p class="text-xs font-semibold uppercase mb-1">Status Saat Ini:</p>
                    <div class="flex items-center space-x-3 mb-4">
                        <span id="status_icon" class="text-3xl"></span>
                        <span id="status_text" class="text-2xl font-extrabold"></span>
                    </div>

                    <!-- Detail Transaksi -->
                    <div class="space-y-2 text-gray-800">
                        <div class="flex justify-between items-center text-sm border-t border-gray-200 pt-2">
                            <span>Kode Transaksi:</span>
                            <span id="detail_kode" class="font-bold"></span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span>Jenis Donasi:</span>
                            <span id="detail_jenis" class="font-medium"></span>
                        </div>
                        <div class="flex justify-between items-center text-lg mt-3 font-bold text-gray-900">
                            <span>Total Pembayaran:</span>
                            <span id="detail_jumlah" class="text-primary"></span>
                        </div>
                    </div>
                </div>

                <!-- Petunjuk Selanjutnya -->
                <div id="next_steps" class="mt-6 p-4 rounded-lg bg-gray-50 border border-gray-200 text-sm text-left">
                    <!-- Konten petunjuk akan diisi oleh JS -->
                </div>

            </div>

            <!-- Pesan Error -->
            <p id="error_message" class="text-center text-lg text-red-500 mt-6 hidden">
                Kode transaksi tidak ditemukan. Pastikan kode sudah benar.
            </p>

        </div>
    </div>
    
    <!-- FOOTER SEDERHANA -->
    <footer class="text-center text-sm text-gray-500 py-4">
        &copy; {{ date('Y') }} Masjid Al-Muttaqin.
    </footer>

    <script>
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        // SIMULASI DATA TRANSAKSI
        const MOCK_TRANSACTIONS = {
            'MUTTAQIN-PENDING': { 
                status: 'PENDING', 
                jenis: 'Zakat Mal (Penghasilan)', 
                jumlah: 2750000, 
                nama: 'Abdul Malik' 
            },
            'MUTTAQIN-VERIFIED': { 
                status: 'VERIFIED', 
                jenis: 'Zakat Fitrah', 
                jumlah: 160000, 
                nama: 'Fatimah Az-Zahra' 
            },
            'MUTTAQIN-REJECTED': { 
                status: 'REJECTED', 
                jenis: 'Infaq Umum', 
                jumlah: 100000, 
                nama: 'Hamba Allah' 
            },
        };

        function checkStatus() {
            const kodeInput = document.getElementById('kode_transaksi_input').value.trim().toUpperCase();
            const resultDiv = document.getElementById('status_result');
            const statusCard = document.getElementById('status_card');
            const errorMsg = document.getElementById('error_message');
            const nextStepsDiv = document.getElementById('next_steps');

            // Reset tampilan
            resultDiv.classList.add('hidden');
            errorMsg.classList.add('hidden');
            statusCard.className = 'p-6 rounded-xl border-l-4 shadow-md transition-colors duration-300'; // Reset classes

            const transaction = MOCK_TRANSACTIONS[kodeInput];

            if (transaction) {
                // 1. Tampilkan detail
                document.getElementById('detail_kode').textContent = kodeInput;
                document.getElementById('detail_jenis').textContent = transaction.jenis;
                document.getElementById('detail_jumlah').textContent = formatRupiah(transaction.jumlah);
                
                // 2. Tentukan tampilan berdasarkan status
                let statusText, statusClass, statusIcon, nextStepsContent;

                switch (transaction.status) {
                    case 'VERIFIED':
                        statusText = 'VERIFIKASI BERHASIL';
                        statusClass = 'status-verified';
                        statusIcon = '✅';
                        nextStepsContent = `Alhamdulillah! Donasi Zakat/Infaq Anda sebesar ${formatRupiah(transaction.jumlah)} telah **diterima dan diverifikasi** oleh DKM. Jazakumullah khairan katsiran.`;
                        break;
                    case 'PENDING':
                        statusText = 'MENUNGGU VERIFIKASI';
                        statusClass = 'status-pending';
                        statusIcon = '⏳';
                        nextStepsContent = `Pembayaran Anda sedang dalam antrian verifikasi. Proses ini biasanya memakan waktu 1x24 jam setelah bukti transfer diunggah. Jika Anda belum mengunggah bukti, silakan klik tombol di bawah.`;
                        // Anda bisa tambahkan tombol untuk mengarahkan ke halaman upload bukti transfer di sini
                        break;
                    case 'REJECTED':
                        statusText = 'TRANSAKSI DITOLAK/KADALUARSA';
                        statusClass = 'status-rejected';
                        statusIcon = '❌';
                        nextStepsContent = `Mohon maaf, transaksi ini dibatalkan karena batas waktu transfer terlampaui atau terdapat ketidaksesuaian pada bukti transfer. Silakan buat donasi baru atau hubungi admin DKM.`;
                        break;
                    default:
                        // Kasus tidak terduga
                        statusText = 'STATUS TIDAK DIKETAHUI';
                        statusClass = 'bg-gray-200 text-gray-700 border-gray-400';
                        statusIcon = '❓';
                        nextStepsContent = `Terjadi kesalahan saat memuat status. Silakan coba lagi atau hubungi admin.`;
                }

                // 3. Update elemen di UI
                document.getElementById('status_text').textContent = statusText;
                document.getElementById('status_icon').textContent = statusIcon;
                statusCard.classList.add(statusClass);
                nextStepsDiv.innerHTML = `<p class="font-semibold mb-1">${transaction.status === 'VERIFIED' ? 'Pesan dari DKM' : 'Langkah Selanjutnya'}:</p> <p>${nextStepsContent}</p>`;
                
                // 4. Tampilkan hasil
                resultDiv.classList.remove('hidden');

            } else {
                // Transaksi tidak ditemukan
                errorMsg.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>