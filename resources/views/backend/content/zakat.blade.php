@extends('backend.layout.main')
@section('title','Data Zakat')

@section('content')
<h4 class="fw-bold mb-4">Data Zakat</h4>

<div class="card card-box p-4">
<table class="table table-hover">
<tr>
<th>Kode</th><th>Nama</th><th>Jenis</th><th>Nominal</th><th>Status</th>
</tr>
@foreach($zakats as $z)
<tr>
<td>{{ $z->kode_transaksi }}</td>
<td>{{ $z->nama }}</td>
<td>{{ $z->jenis_zakat }}</td>
<td>Rp {{ number_format($z->nominal,0,',','.') }}</td>
<td>{{ $z->status }}</td>
</tr>
@endforeach
</table>
</div>
@endsection
