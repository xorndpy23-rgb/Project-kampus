<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masjid Al-Muttaqin | Zakat dan Infaq Online</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        :root {
            --color-primary: #0ea766;
            --color-primary-dark: #0b8a55;
            --soft-bg: #fff7ef;
        }

        .bg-primary { background-color: var(--color-primary); }
        .text-primary { color: var(--color-primary); }
        .hover\:bg-primary-dark:hover { background-color: var(--color-primary-dark); }
        
        /* Custom animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Floating animation for cards */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-800">

    <!-- WRAPPER -->
    <div class="relative min-h-screen flex flex-col">

        <!-- NAVBAR -->
        <header class="sticky top-0 z-50 w-full py-4 px-6 sm:px-10 bg-white shadow-lg flex justify-between items-center">
            <div class="text-2xl font-extrabold text-primary">
                <span class="text-gray-900">Al-Muttaqin</span>
            </div>

            <nav class="hidden md:flex space-x-6 text-sm font-medium">
                <a href="#layanan" class="text-gray-600 hover:text-primary transition-colors">Layanan</a>
                <a href="#keunggulan" class="text-gray-600 hover:text-primary transition-colors">Keunggulan</a>
                <a href="#statistik" class="text-gray-600 hover:text-primary transition-colors">Statistik</a>
                <a href="#testimoni" class="text-gray-600 hover:text-primary transition-colors">Testimoni</a>
            </nav>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('beranda.index') }}" class="text-sm font-semibold text-primary hover:text-primary-dark transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('auth.index') }}" class="text-sm font-semibold text-gray-600 hover:text-primary transition-colors">Login Admin</a>
                    <a href="{{ route('zakat.create') }}"
                        class="px-4 py-2 text-sm font-bold rounded-full bg-primary text-white hover:bg-primary-dark transition-all transform hover:scale-105 shadow-md">
                        Bayar Zakat
                    </a>
                @endauth
            </div>
        </header>

        <!-- HERO SECTION -->
        <section class="relative py-20 md:py-32 bg-gradient-to-br from-green-50 to-emerald-100 overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-72 h-72 bg-primary rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float"></div>
                <div class="absolute top-0 right-0 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float animation-delay-2000"></div>
                <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float animation-delay-4000"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-primary text-sm font-semibold mb-8 fade-in">
                    <span class="w-2 h-2 bg-primary rounded-full mr-2"></span>
                    AMANAH · TRANSPARAN · TERPERCAYA
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight fade-in">
                    Memuliakan<br>
                    <span class="text-primary">Ibadah Zakat</span><br>
                    dan Infaq Anda
                </h1>

                <!-- Description -->
                <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed fade-in">
                    Platform digital untuk menunaikan zakat & infaq dengan mudah, aman, dan terpercaya. 
                    Bersama kami, setiap rupiah tersalurkan tepat sasaran.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center fade-in">
                    <a href="{{ route('zakat.create') }}"
                        class="px-8 py-4 bg-primary text-white text-lg font-bold rounded-full hover:bg-primary-dark transition-all transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center gap-2">
                        <span></span>
                        Tunaikan Zakat & Infaq Sekarang
                    </a>
                    
                    <a href="#layanan"
                        class="px-8 py-4 border-2 border-primary text-primary text-lg font-bold rounded-full hover:bg-primary hover:text-white transition-all transform hover:scale-105">
                        Pelajari Lebih Lanjut
                    </a>
                </div>

                <!-- Stats Preview -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16 max-w-4xl mx-auto fade-in">
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-primary mb-2">1.5M+</div>
                        <div class="text-sm text-gray-600">Dana Tersalurkan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-primary mb-2">4.2K+</div>
                        <div class="text-sm text-gray-600">Muzakki</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-primary mb-2">15+</div>
                        <div class="text-sm text-gray-600">Program Sosial</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold text-primary mb-2">100%</div>
                        <div class="text-sm text-gray-600">Tepat Sasaran</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- LAYANAN SECTION -->
        <section id="layanan" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Layanan Kami
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Berbagai jenis zakat dan infaq untuk memudahkan ibadah Anda
                    </p>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Zakat Fitrah -->
                    <div class="group bg-gradient-to-br from-white to-green-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 fade-in border border-green-100 hover:border-primary/20">
                        <div class="text-6xl mb-6 text-center group-hover:scale-110 transition-transform duration-300">🌾</div>
                        <h3 class="text-2xl font-bold text-center mb-4 text-gray-900">Zakat Fitrah</h3>
                        <p class="text-gray-600 text-center leading-relaxed">
                            Zakat wajib yang ditunaikan setiap muslim di bulan Ramadhan sebagai pembersih jiwa.
                        </p>
                        <div class="mt-6 text-center">
                            <span class="inline-block px-4 py-2 bg-green-100 text-primary rounded-full text-sm font-semibold">
                                Wajib bagi setiap muslim
                            </span>
                        </div>
                    </div>

                    <!-- Zakat Mal -->
                    <div class="group bg-gradient-to-br from-white to-blue-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 fade-in border border-blue-100 hover:border-primary/20">
                        <div class="text-6xl mb-6 text-center group-hover:scale-110 transition-transform duration-300">💰</div>
                        <h3 class="text-2xl font-bold text-center mb-4 text-gray-900">Zakat Mal</h3>
                        <p class="text-gray-600 text-center leading-relaxed">
                            Zakat harta seperti penghasilan, emas, tabungan, dan properti yang telah mencapai nisab.
                        </p>
                        <div class="mt-6 text-center">
                            <span class="inline-block px-4 py-2 bg-blue-100 text-primary rounded-full text-sm font-semibold">
                                2.5% dari harta
                            </span>
                        </div>
                    </div>

                    <!-- Infaq & Sedekah -->
                    <div class="group bg-gradient-to-br from-white to-purple-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 fade-in border border-purple-100 hover:border-primary/20">
                        <div class="text-6xl mb-6 text-center group-hover:scale-110 transition-transform duration-300">💖</div>
                        <h3 class="text-2xl font-bold text-center mb-4 text-gray-900">Infaq & Sedekah</h3>
                        <p class="text-gray-600 text-center leading-relaxed">
                            Donasi sukarela untuk mendukung program sosial, pendidikan, dan kemanusiaan masjid.
                        </p>
                        <div class="mt-6 text-center">
                            <span class="inline-block px-4 py-2 bg-purple-100 text-primary rounded-full text-sm font-semibold">
                                Sunnah & berpahala
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- KEUNGGULAN SECTION -->
        <section id="keunggulan" class="py-20 bg-gradient-to-br from-gray-50 to-green-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Mengapa Memilih Kami?
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Keunggulan platform Al-Muttaqin dalam menyalurkan zakat Anda
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8">
                        <div class="flex items-start space-x-6 fade-in">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                01
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Transparansi Penuh</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Pantau laporan penyaluran dana secara real-time. Setiap rupiah yang Anda titipkan dapat dilacak hingga ke penerima manfaat.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-6 fade-in">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                02
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Keamanan Terjamin</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Sistem pembayaran terenkripsi dan diawasi oleh Dewan Syariah. Data dan transaksi Anda aman bersama kami.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-6 fade-in">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                03
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Akses 24/7</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Bayar zakat kapan saja, di mana saja. Tidak perlu datang ke masjid, semua bisa dilakukan dari genggaman tangan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Visual -->
                    <div class="relative fade-in">
                        <div class="bg-white rounded-2xl p-8 shadow-xl border border-green-100">
                            <div class="text-center">
                                <div class="text-6xl mb-4">🕌</div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">Masjid Al-Muttaqin</h4>
                                <p class="text-gray-600">Lembaga terpercaya sejak 1985</p>
                                
                                <div class="mt-6 grid grid-cols-2 gap-4">
                                    <div class="text-center p-4 bg-green-50 rounded-lg">
                                        <div class="text-2xl font-bold text-primary">35+</div>
                                        <div class="text-sm text-gray-600">Tahun</div>
                                    </div>
                                    <div class="text-center p-4 bg-green-50 rounded-lg">
                                        <div class="text-2xl font-bold text-primary">A+</div>
                                        <div class="text-sm text-gray-600">Akhlaq</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating elements -->
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-yellow-100 rounded-2xl flex items-center justify-center text-2xl float-animation">
                            ⚡
                        </div>
                        <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-xl float-animation" style="animation-delay: 2s;">
                            🛡️
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <!-- STATISTIK SECTION  -->
    <section id="statistik" class="py-20 bg-gradient-to-br from-green-600 to-green-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16 fade-in">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Dampak Nyata Zakat Anda
                </h2>
                <p class="text-lg text-green-100 max-w-2xl mx-auto">
                    Setiap kontribusi Anda membawa perubahan nyata bagi masyarakat
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center fade-in">
                    <div class="text-4xl md:text-5xl font-bold mb-2 text-white">1.5M+</div>
                    <div class="text-green-200 text-sm font-semibold uppercase tracking-wider">Dana Tersalurkan</div>
                    <div class="mt-2 text-green-300 text-xs">Dalam Rupiah</div>
                </div>

                <div class="text-center fade-in">
                    <div class="text-4xl md:text-5xl font-bold mb-2 text-white">4.2K+</div>
                    <div class="text-green-200 text-sm font-semibold uppercase tracking-wider">Muzakki</div>
                    <div class="mt-2 text-green-300 text-xs">Donatur Aktif</div>
                </div>

                <div class="text-center fade-in">
                    <div class="text-4xl md:text-5xl font-bold mb-2 text-white">15+</div>
                    <div class="text-green-200 text-sm font-semibold uppercase tracking-wider">Program Sosial</div>
                    <div class="mt-2 text-green-300 text-xs">Aktif Berjalan</div>
                </div>

                <div class="text-center fade-in">
                    <div class="text-4xl md:text-5xl font-bold mb-2 text-white">100%</div>
                    <div class="text-green-200 text-sm font-semibold uppercase tracking-wider">Tepat Sasaran</div>
                    <div class="mt-2 text-green-300 text-xs">Akuntabilitas</div>
                </div>
            </div>

            <!-- Impact Description  -->
            <div class="mt-16 text-center fade-in">
                <div class="inline-flex items-center gap-4 bg-white/20 backdrop-blur-sm rounded-2xl px-8 py-6 border-2 border-white/30">
                    <span class="text-3xl"></span>
                    <div>
                        <p class="text-white font-bold text-lg mb-1">1.500+  Terbantu</p>
                        <p class="text-green-200 text-sm">telah merasakan manfaat dari zakat yang Anda salurkan</p>
                    </div>
                    <span class="text-3xl"></span>
                </div>
            </div>
        </div>
    </section>
                
        <!-- TESTIMONI SECTION -->
        <section id="testimoni" class="py-20 bg-gradient-to-br from-amber-50 to-orange-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16 fade-in">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Apa Kata Mereka?
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Testimoni nyata dari para muzakki dan mustahik
                    </p>
                </div>

              <!-- Testimoni Slider -->
<div class="relative">
    <div class="swiper myTestimoni">
        <div class="swiper-wrapper">
            @foreach ([
                [
                    "nama" => "Biyan",
                    "img"  => "biyan.jpeg",
                    "isi"  => "Terima kasih yang sebesar-besarnya saya sampaikan dari lubuk hati terdalam. Kehadiran, dukungan, dan kebaikan yang telah diberikan bukan hanya menjadi penguat di saat-saat sulit, tetapi juga menjadi cahaya yang menuntun saya untuk terus melangkah..."
                ],
                [
                    "nama" => "Danang", 
                    "img"  => "danang.jpeg",
                    "isi"  => "Saya dan keluarga sangat berterima kasih atas bantuan yang telah diberikan. Di saat situasi terasa berat, uluran tangan ini menjadi penopang yang luar biasa..."
                ],
                [
                    "nama" => "Syifa",
                    "img"  => "syifa.jpeg", 
                    "isi"  => "Bantuan yang saya terima benar-benar memberikan dampak besar dalam kehidupan keluarga kami. Hal kecil sekalipun, jika diberikan dengan tulus, dapat menjadi sangat berarti..."
                ],
                [
                    "nama" => "Riang",
                    "img"  => "riang.jpeg",
                    "isi"  => "Alhamdulillah, bantuan ini sangat berarti bagi saya dan keluarga. Di tengah kesulitan yang kami hadapi, hadirnya bantuan dari Masjid Al-Muttaqin menjadi bukti bahwa Allah selalu mengirimkan pertolongan..."
                ],
                [
                    "nama" => "Fajri",
                    "img"  => "fajri.jpeg",
                    "isi"  => "Saya ingin mengucapkan terima kasih yang sebesar-besarnya kepada para donatur dan pengurus masjid. Bantuan ini sangat membantu memenuhi kebutuhan harian keluarga kami..."
                ],
                [
                    "nama" => "Damar",
                    "img"  => "damar.jpeg",
                    "isi"  => "Semoga Allah membalas setiap kebaikan dan niat tulus para donatur. Bantuan ini menjadi penyemangat bagi kami untuk terus berusaha dan tidak menyerah..."
                ]
            ] as $t)
            <div class="swiper-slide">
                <div class="bg-white rounded-2xl shadow-lg p-6 h-full border border-orange-100 hover:shadow-xl transition-all duration-300">
                    <div class="text-center mb-4">
                        <!-- Foto dengan fallback ke inisial -->
                        <div class="w-20 h-20 rounded-full bg-gradient-to-r from-primary to-primary-dark mx-auto mb-3 flex items-center justify-center text-white text-xl font-bold relative overflow-hidden">
                            @if(file_exists(public_path('assets/img/' . $t['img'])))
                                <img src="{{ asset('assets/img/' . $t['img']) }}" 
                                     alt="{{ $t['nama'] }}"
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @endif
                            <div class="absolute inset-0 flex items-center justify-center {{ file_exists(public_path('assets/img/' . $t['img'])) ? 'hidden' : '' }}">
                                {{ substr($t['nama'], 0, 1) }}
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $t['nama'] }}</h3>
                        <div class="flex justify-center mt-1 text-yellow-400">
                            ★★★★★
                        </div>
                    </div>
                    
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-4">
                        {{ Str::limit($t['isi'], 120) }}
                    </p>
                    
                    <button class="btn-selengkapnya w-full mt-4 px-4 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600 transition-colors"
                        data-nama="{{ $t['nama'] }}"
                        data-isi="{{ $t['isi'] }}">
                        Baca Selengkapnya
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Navigation -->
    <div class="swiper-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white shadow-lg w-10 h-10 flex items-center justify-center rounded-full cursor-pointer z-10 hover:bg-gray-50 transition-colors">
        ‹
    </div>
    <div class="swiper-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white shadow-lg w-10 h-10 flex items-center justify-center rounded-full cursor-pointer z-10 hover:bg-gray-50 transition-colors">
        ›
    </div>
</div>
                    <!-- Navigation -->
                    <div class="swiper-prev absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white shadow-lg w-10 h-10 flex items-center justify-center rounded-full cursor-pointer z-10 hover:bg-gray-50 transition-colors">
                        ‹
                    </div>
                    <div class="swiper-next absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white shadow-lg w-10 h-10 flex items-center justify-center rounded-full cursor-pointer z-10 hover:bg-gray-50 transition-colors">
                        ›
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA SECTION -->
      
<section class="py-16 bg-gradient-to-br from-green-700 to-green-900 text-white">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold mb-6 fade-in">
            Siap Menunaikan Zakat?
        </h2>
        <p class="text-lg text-green-200 mb-8 fade-in">
            Mari bersama-sama membersihkan harta dan menyucikan jiwa melalui zakat
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in">
            <a href="{{ route('zakat.create') }}"
                class="px-8 py-4 bg-white text-green-700 text-lg font-bold rounded-full hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                <span class="text-xl"></span>
                Tunaikan Zakat Sekarang
            </a>
            <a href="#layanan"
                class="px-8 py-4 bg-transparent border-2 border-white text-white text-lg font-bold rounded-full hover:bg-white hover:text-green-700 transition-all transform hover:scale-105 flex items-center justify-center gap-2 shadow-lg">
                <span class="text-xl"></span>
                Pelajari Tentang Zakat
            </a>
        </div>
    </div>
</section>
        <!-- FOOTER -->
        <footer class="py-12 bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Brand -->
                    <div class="md:col-span-2">
                        <div class="text-2xl font-bold text-primary mb-4">Al-Muttaqin</div>
                        <p class="text-gray-400 mb-4 max-w-md">
                            Platform digital zakat dan infaq yang amanah, transparan, dan terpercaya. 
                            Menjadi penghubung antara muzakki dan mustahik dengan prinsip syariah.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">📘</a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">📸</a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">🎥</a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                        <div class="space-y-2">
                            <a href="#layanan" class="block text-gray-400 hover:text-white transition-colors">Layanan</a>
                            <a href="#keunggulan" class="block text-gray-400 hover:text-white transition-colors">Keunggulan</a>
                            <a href="#statistik" class="block text-gray-400 hover:text-white transition-colors">Statistik</a>
                            <a href="#testimoni" class="block text-gray-400 hover:text-white transition-colors">Testimoni</a>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                        <div class="space-y-2 text-gray-400">
                            <p>📧 info@al-muttaqin.id</p>
                            <p>📱 +62 812-3456-7890</p>
                            <p>�️ Jl. Kebajikan No. 123</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2024 Masjid Al-Muttaqin. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </div>

    <!-- MODAL -->
    <div id="modalTestimoni" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4">
        <div class="bg-white p-6 max-w-2xl w-full rounded-2xl shadow-2xl relative max-h-[90vh] overflow-y-auto">
            <button onclick="tutupModal()" class="absolute top-4 right-4 text-2xl text-gray-500 hover:text-gray-700 transition-colors">✕</button>
            
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-primary to-primary-dark mx-auto mb-3 flex items-center justify-center text-white text-xl font-bold" id="modalAvatar">
                    A
                </div>
                <h2 id="modalNama" class="text-2xl font-bold text-gray-900"></h2>
                <div class="flex justify-center mt-2 text-yellow-400">
                    ★★★★★
                </div>
            </div>
            
            <p id="modalIsi" class="text-gray-700 leading-relaxed text-lg"></p>
            
            <div class="mt-6 text-center">
                <button onclick="tutupModal()" class="px-6 py-2 bg-primary text-white rounded-full hover:bg-primary-dark transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- SWIPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Initialize Swiper
        const swiper = new Swiper('.myTestimoni', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
            navigation: {
                nextEl: '.swiper-next',
                prevEl: '.swiper-prev',
            },
        });

        // Modal functionality
        document.querySelectorAll('.btn-selengkapnya').forEach(btn => {
            btn.addEventListener('click', () => {
                const nama = btn.dataset.nama;
                const isi = btn.dataset.isi;
                
                document.getElementById("modalNama").innerText = nama;
                document.getElementById("modalIsi").innerText = isi;
                document.getElementById("modalAvatar").innerText = nama.charAt(0);
                document.getElementById("modalTestimoni").classList.remove("hidden");
            });
        });

        function tutupModal() {
            document.getElementById("modalTestimoni").classList.add("hidden");
        }

        // Close modal on outside click
        document.getElementById('modalTestimoni').addEventListener('click', function(e) {
            if (e.target === this) {
                tutupModal();
            }
        });

        // Fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Add floating animation delay classes
        document.querySelectorAll('.float-animation').forEach((el, index) => {
            el.style.animationDelay = `${index * 2}s`;
        });
    </script>

</body>
</html>