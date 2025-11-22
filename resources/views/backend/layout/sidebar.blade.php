<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('beranda.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-mosque"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Masjid Al-Muttaqin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Beranda -->
    {{-- Menggunakan 'dashboard' sebagai nama rute standar untuk Beranda --}}
    <li class="nav-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('beranda.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Beranda</span>
        </a>
    </li>
    
    <!-- Nav Item - Pengguna -->
    {{-- Asumsi rute untuk Pengguna adalah 'user.index' atau 'user.*' --}}
    <li class="nav-item {{ Request::routeIs('user.*') ? 'active' : '' }}">
        <a class="nav-link" href="index.html}">
            <i class="fas fa-fw fa-user"></i>
            <span>Pengguna Admin</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Keuangan
    </div>  

    <!-- Nav Item - Transaksi (Pemasukan & Verifikasi) -->
    {{-- Aktif jika rute dimulai dengan 'transaksi.' atau 'verifikasi.' --}}
    <li class="nav-item {{ Request::routeIs('transaksi.*') || Request::routeIs('verifikasi.*') ? 'active' : '' }}">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Daftar Transaksi</span>
        </a>
    </li>
    
    <!-- Nav Item - Laporan -->
    <li class="nav-item {{ Request::routeIs('laporan.*') ? 'active' : '' }}">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Laporan Keuangan</span>
        </a>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">
    
    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan Program
    </div>
    
    <!-- Nav Item - Program Zakat & Infaq -->
    <li class="nav-item {{ Request::routeIs('program.*') ? 'active' : '' }}">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-hand-holding-heart"></i>
            <span>Program Zakat</span>
        </a>
    </li>
    
    <!-- Nav Item - Kegiatan -->
    <li class="nav-item {{ Request::routeIs('kegiatan.*') ? 'active' : '' }}">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Kegiatan Masjid</span>
        </a>
    </li>
    
    <!-- Nav Item - Informasi Masjid -->
    <li class="nav-item {{ Request::routeIs('informasi.*') ? 'active' : '' }}">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-info-circle"></i>
            <span>Info Kontak & Profil</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>