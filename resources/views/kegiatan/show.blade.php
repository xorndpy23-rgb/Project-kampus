{{-- resources/views/kegiatan/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }} | Masjid Al-Muttaqin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --color-primary: #0ea766;
            --color-primary-dark: #0b8a55;
        }
        .bg-primary { background-color: var(--color-primary); }
        .text-primary { color: var(--color-primary); }
        .hover\:bg-primary-dark:hover { background-color: var(--color-primary-dark); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    {{-- Navbar --}}
    <header class="sticky top-0 z-50 w-full py-4 px-6 bg-white shadow flex justify-between items-center">
        <div class="text-2xl font-bold text-primary">Al-Muttaqin</div>
        <nav class="hidden md:flex space-x-6 text-sm font-medium">
            <a href="/" class="text-gray-600 hover:text-primary transition-colors">Beranda</a>
            <a href="#layanan" class="text-gray-600 hover:text-primary transition-colors">Layanan</a>
            <a href="#kegiatan masjid" class="text-gray-600 hover:text-primary transition-colors">Kegiatan</a>
        </nav>
    </header>



    {{-- Konten --}}
    <section class="py-16 max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

            {{-- Foto --}}
            <div class="overflow-hidden rounded-3xl shadow-lg">
                @if($data['title'] === 'Kajian Rutin')
                    <img src="https://umsida.ac.id/wp-content/uploads/2023/03/WhatsApp-Image-2023-03-08-at-14.01.16.jpeg" 
                         alt="{{ $data['title'] }}" 
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                @elseif($data['title'] === 'TPA & Tahfidz')
                    <img src="https://tse4.mm.bing.net/th/id/OIP.M1_eSyfPRPiBn4Ku4eTILgHaFj?cb=ucfimg2&ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3" 
                         alt="{{ $data['title'] }}" 
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                @elseif($data['title'] === 'Bakti Sosial')
                    <img src="https://fkh.ugm.ac.id/wp-content/uploads/sites/14/2020/08/1598848564189.jpg" 
                         alt="{{ $data['title'] }}" 
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                @else
                    <img src="https://via.placeholder.com/600x400?text=Kegiatan+Masjid" 
                         alt="{{ $data['title'] }}" 
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                @endif
            </div>

            {{-- Deskripsi lengkap --}}
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $data['title'] }}</h2>
                <p class="text-gray-700 text-lg leading-relaxed mb-6">{{ $data['description'] }}</p>

                <div class="space-y-3">
                    <p class="text-gray-600"><strong>Jadwal:</strong> {{ $data['title'] === 'Kajian Rutin' ? 'Selasa & Jumat, Ba’da Maghrib' : ($data['title'] === 'TPA & Tahfidz' ? 'Setiap Sore' : 'Bervariasi sesuai kegiatan') }}</p>
                    <p class="text-gray-600"><strong>Tempat:</strong> Masjid Al-Muttaqin</p>
                    <p class="text-gray-600"><strong>Kontak:</strong> 📱 +62 812-3456-7890</p>
                </div>

                <a href="/" class="inline-block mt-6 px-6 py-3 bg-primary text-white font-semibold rounded-full hover:bg-primary-dark transition-colors">
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-12 bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            &copy; 2024 Masjid Al-Muttaqin. All rights reserved.
        </div>
    </footer>

</body>
</html>
