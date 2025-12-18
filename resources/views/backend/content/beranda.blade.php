@extends('backend.layout.main')
@section('title','Dashboard')

@section('content')
<h4 class="fw-bold mb-4">Dashboard</h4>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-box p-3">
            <small>Total Pemasukan</small>
            <h5 class="fw-bold">Rp {{ number_format($totalPemasukan,0,',','.') }}</h5>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-box p-3">
            <small>Transaksi Berhasil</small>
            <h5 class="fw-bold">{{ $transaksiBerhasil }}</h5>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-box p-3">
            <small>Transaksi Pending</small>
            <h5 class="fw-bold">{{ $transaksiPending }}</h5>
        </div>
    </div>
</div>

<div class="card card-box p-4 mb-4">
    <h5 class="fw-bold">Grafik Pemasukan Bulanan</h5>
    <canvas id="chartZakat"></canvas>
</div>

<div class="card card-box p-4">
    <h5 class="fw-bold">Transaksi Terbaru</h5>
    <table class="table table-hover mt-3">
        <thead>
            <tr>
                <th>Kode</th><th>Nama</th><th>Jenis</th><th>Nominal</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksiTerbaru as $z)
            <tr>
                <td>{{ $z->kode_transaksi }}</td>
                <td>{{ $z->nama }}</td>
                <td>{{ $z->jenis_zakat }}</td>
                <td>Rp {{ number_format($z->nominal,0,',','.') }}</td>
                <td>
                    <span class="badge bg-{{ $z->status=='success'?'success':'warning' }}">
                        {{ $z->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
new Chart(document.getElementById('chartZakat'),{
    type:'line',
    data:{
        labels:@json($bulan),
        datasets:[{
            label:'Pemasukan',
            data:@json($pemasukanBulanan),
            borderWidth:3,
            fill:true
        }]
    }
});
</script>
@endsection
