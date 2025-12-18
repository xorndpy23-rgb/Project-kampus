<aside class="sidebar pt-4">
    <h5 class="text-center fw-bold mb-4">SIM MASJID</h5>

    <a href="{{ route('admin.beranda') }}">
        <i class="fa fa-home"></i> Dashboard
    </a>

    <a href="{{ route('admin.users') }}">
        <i class="fa fa-users"></i> Kelola User
    </a>

    <a href="{{ route('admin.zakat') }}">
        <i class="fa fa-hand-holding-heart"></i> Data Zakat
    </a>

    <a href="{{ route('admin.laporan') }}">
        <i class="fa fa-file-alt"></i> Laporan
    </a>

    <hr class="text-white">

    <form action="{{ route('auth.logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger">Logout</button>
</form>

        
</aside>
