@extends('backend.layout.main')
@section('title','Laporan Transaksi')

@section('content')
<h4 class="fw-bold mb-4">Laporan Transaksi</h4>

{{-- Filter --}}
<div class="card card-box p-4 mb-4">
    <form action="{{ route('admin.laporan') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="jenis" class="form-label">Jenis Zakat</label>
            <select name="jenis" id="jenis" class="form-select">
                <option value="">-- Semua --</option>
                <option value="mal" {{ request('jenis')=='mal'?'selected':'' }}>Mal</option>
                <option value="fitrah" {{ request('jenis')=='fitrah'?'selected':'' }}>Fitrah</option>
                <option value="infaq" {{ request('jenis')=='infaq'?'selected':'' }}>Infaq</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="">-- Semua --</option>
                <option value="success" {{ request('status')=='success'?'selected':'' }}>Success</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="failed" {{ request('status')=='failed'?'selected':'' }}>Failed</option>
                <option value="expired" {{ request('status')=='expired'?'selected':'' }}>Expired</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>
</div>

{{-- Ringkasan --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-box p-3">
            <small>Total Pemasukan</small>
            <h5 class="fw-bold">Rp {{ number_format($totalPemasukan ?? 0,0,',','.') }}</h5>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-box p-3">
            <small>Transaksi Berhasil</small>
            <h5 class="fw-bold">{{ $transaksiBerhasil ?? 0 }}</h5>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-box p-3">
            <small>Transaksi Pending</small>
            <h5 class="fw-bold">{{ $transaksiPending ?? 0 }}</h5>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-box p-3">
            <small>Total Donatur</small>
            <h5 class="fw-bold">{{ $totalDonatur ?? 0 }}</h5>
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="card card-box p-4">
    <h5 class="fw-bold mb-3">Daftar Transaksi</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $z)
            <tr>
                <td>{{ $z->kode_transaksi }}</td>
                <td>{{ $z->nama }}</td>
                <td>{{ ucfirst($z->jenis_zakat) }}</td>
                <td>Rp {{ number_format($z->nominal,0,',','.') }}</td>
                <td>
                    <span class="badge bg-{{ $z->status=='success'?'success':($z->status=='pending'?'warning':'danger') }}">
                        {{ ucfirst($z->status) }}
                    </span>
                </td>
                <td>{{ $z->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-3">
    {{ $transaksi->links('pagination::bootstrap-5') }}
</div>

@endsection

<style>
.pagination .page-link {
    padding: 0.25rem 0.5rem; /* Mengecilkan tombol */
    font-size: 0.875rem;     /* Font lebih kecil */
}
.pagination .page-item.disabled .page-link {
    pointer-events: none;
    opacity: 0.5;
}
</style>