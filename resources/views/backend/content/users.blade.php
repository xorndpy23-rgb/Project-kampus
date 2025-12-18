@extends('backend.layout.main')
@section('title','Kelola User')

@section('content')
<h4 class="fw-bold mb-4">Kelola User</h4>

<div class="card card-box p-4">
<table class="table">
<tr><th>Nama</th><th>Email</th><th>Role</th></tr>
@foreach($users as $u)
<tr>
    <td>{{ $u->name }}</td>
    <td>{{ $u->email }}</td>
    <td>{{ $u->role }}</td>
</tr>
@endforeach
</table>
</div>
@endsection
