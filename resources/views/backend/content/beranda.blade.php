<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | Verifikasi Zakat</title>

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
        .hover\:bg-primary-dark:hover { background-color: var(--color-primary-dark); }
        
        .status-badge {
            @apply px-3 py-1 text-xs font-bold rounded-full uppercase;
        }
        .status-PENDING { @apply bg-yellow-100 text-yellow-800; }
        .status-VERIFIED { @apply bg-green-100 text-green-800; }
        .status-REJECTED { @apply bg-red-100 text-red-800; }
    </style>
</head>
<body class="antialiased bg-gray-100 text-gray-800">

    <!-- LOGIN SCREEN (Default View) -->
    <div id="login_screen" class="min-h-screen flex items-center justify-center bg-gray-900 transition-opacity duration-300">
        <div class="w-full max-w-sm bg-white rounded-xl shadow-2xl p-8 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Login Admin</h1>
            <p class="text-gray-500 mb-6">Akses DKM Masjid Al-Muttaqin</p>
            
            <input type="password" id="admin_password" placeholder="Password"
                class="w-full border border-gray-300 rounded-lg p-3 mb-4 focus:ring-primary focus:border-primary">
            
            <p id="login_error" class="text-sm text-red-500 mb-4 hidden">Password salah. Coba lagi.</p>

            <button onclick="simulateLogin()"
                    class="w-full px-6 py-3 font-bold rounded-lg text-white bg-primary hover:bg-primary-dark transition duration-200">
                Masuk ke Dashboard
            </button>
            <p class="text-xs text-gray-400 mt-3">Hint: admin123</p>
        </div>
    </div>
    
    <!-- MAIN ADMIN DASHBOARD -->
    <div id="admin_dashboard" class="hidden min-h-screen">
        <header class="bg-white shadow-md p-4 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Verifikasi Donasi DKM</h1>
                <button onclick="simulateLogout()" class="text-sm text-red-500 hover:text-red-700 font-semibold">
                    Logout
                </button>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            
            <div id="stats_summary" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Stat Card 1: Pending -->
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-400">
                    <p class="text-sm font-medium text-gray-500">Menunggu Verifikasi</p>
                    <p id="stat_pending" class="text-3xl font-extrabold text-yellow-600 mt-1"></p>
                </div>
                <!-- Stat Card 2: Verified -->
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-400">
                    <p class="text-sm font-medium text-gray-500">Telah Diverifikasi</p>
                    <p id="stat_verified" class="text-3xl font-extrabold text-green-600 mt-1"></p>
                </div>
                <!-- Stat Card 3: Total Donasi (Simulasi Rupiah) -->
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-primary">
                    <p class="text-sm font-medium text-gray-500">Total Donasi (Verified)</p>
                    <p id="stat_total_amount" class="text-3xl font-extrabold text-primary mt-1"></p>
                </div>
            </div>

            <!-- TABEL TRANSAKSI -->
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <div class="p-6 bg-gray-50 border-b">
                    <h2 class="text-xl font-bold text-gray-900">Antrian Bukti Transfer</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donatur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis & Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="transaction_list" class="bg-white divide-y divide-gray-200">
                            <!-- Rows will be injected by JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div id="no_pending_message" class="text-center p-8 text-gray-500 hidden">
                    <p>🥳 Tidak ada transaksi yang menunggu verifikasi saat ini. Anda telah bersih!</p>
                </div>
            </div>

        </main>
    </div>

    <script>
        // --- DATA MOCK (SIMULASI DATABASE) ---
        let transactions = [
            { id: 1, kode: 'MTQ-54321', nama: 'Abdul Karim', jenis: 'Zakat Mal', jumlah: 5200000, status: 'PENDING' },
            { id: 2, kode: 'MTQ-98765', nama: 'Siti Fatonah', jenis: 'Zakat Fitrah (4 Jiwa)', jumlah: 160000, status: 'PENDING' },
            { id: 3, kode: 'MTQ-11223', nama: 'Hamba Allah', jenis: 'Infaq Umum', jumlah: 500000, status: 'VERIFIED' },
            { id: 4, kode: 'MTQ-44556', nama: 'Zahra Dewi', jenis: 'Zakat Mal', jumlah: 800000, status: 'REJECTED' },
            { id: 5, kode: 'MTQ-67890', nama: 'Bambang Sudiro', jenis: 'Infaq Pendidikan', jumlah: 750000, status: 'PENDING' },
        ];

        // --- AUTH LOGIC (SIMULASI) ---
        const CORRECT_PASSWORD = "admin123";
        let isAuthenticated = false;

        function simulateLogin() {
            const passwordInput = document.getElementById('admin_password').value;
            const errorMsg = document.getElementById('login_error');
            
            if (passwordInput === CORRECT_PASSWORD) {
                isAuthenticated = true;
                localStorage.setItem('admin_auth', 'true');
                errorMsg.classList.add('hidden');
                document.getElementById('login_screen').classList.add('hidden');
                document.getElementById('admin_dashboard').classList.remove('hidden');
                renderDashboard();
            } else {
                errorMsg.classList.remove('hidden');
            }
        }

        function simulateLogout() {
            isAuthenticated = false;
            localStorage.removeItem('admin_auth');
            document.getElementById('admin_password').value = '';
            document.getElementById('admin_dashboard').classList.add('hidden');
            document.getElementById('login_screen').classList.remove('hidden');
        }

        // Check initial auth state
        window.onload = function() {
            if (localStorage.getItem('admin_auth') === 'true') {
                isAuthenticated = true;
                document.getElementById('login_screen').classList.add('hidden');
                document.getElementById('admin_dashboard').classList.remove('hidden');
                renderDashboard();
            }
        };

        // --- DASHBOARD RENDERING & UTILITIES ---

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        }

        function calculateStats() {
            const pending = transactions.filter(t => t.status === 'PENDING').length;
            const verified = transactions.filter(t => t.status === 'VERIFIED').length;
            const totalVerifiedAmount = transactions
                .filter(t => t.status === 'VERIFIED')
                .reduce((sum, t) => sum + t.jumlah, 0);

            document.getElementById('stat_pending').textContent = pending;
            document.getElementById('stat_verified').textContent = verified;
            document.getElementById('stat_total_amount').textContent = formatRupiah(totalVerifiedAmount);

            return pending;
        }

        function renderTransactions() {
            const tbody = document.getElementById('transaction_list');
            tbody.innerHTML = '';
            const pendingCount = calculateStats();

            // Sembunyikan pesan jika ada yang pending, atau tampilkan jika tidak ada
            document.getElementById('no_pending_message').classList.toggle('hidden', pendingCount > 0);

            // Tampilkan hanya transaksi PENDING
            const pendingTransactions = transactions.filter(t => t.status === 'PENDING');

            pendingTransactions.forEach(t => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                
                // Status Badge HTML
                const statusBadge = `<span class="status-badge status-${t.status}">${t.status}</span>`;

                // Action Buttons HTML
                const actionsHtml = `
                    <button onclick="updateStatus(${t.id}, 'VERIFIED')" 
                            class="text-green-600 hover:text-green-800 font-semibold text-sm mr-3">
                        Verifikasi
                    </button>
                    <button onclick="updateStatus(${t.id}, 'REJECTED')" 
                            class="text-red-600 hover:text-red-800 font-semibold text-sm">
                        Tolak
                    </button>
                `;

                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${t.kode}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${t.nama}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        <span class="font-semibold">${t.jenis}</span><br>
                        <span class="text-xs text-primary">${formatRupiah(t.jumlah)}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${statusBadge}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        ${t.status === 'PENDING' ? actionsHtml : ''}
                    </td>
                `;
                tbody.appendChild(row);
            });
            
            
        }

        function updateStatus(id, newStatus) {
            const index = transactions.findIndex(t => t.id === id);
            if (index !== -1) {
                transactions[index].status = newStatus;
                renderTransactions();
                
                
                console.log(`Transaksi ${id} diperbarui ke status: ${newStatus}`);
            }
        }

        function renderDashboard() {
            if (isAuthenticated) {
                renderTransactions();
            }
        }
    </script>
</body>
</html>
