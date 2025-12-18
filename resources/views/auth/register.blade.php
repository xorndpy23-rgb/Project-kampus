<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Masjid Al-Muttaqin | Daftar Akun</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{box-sizing:border-box}

body{
    margin:0;
    font-family:'Inter',sans-serif;
    min-height:100vh;
    background:
      linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.55)),
      url('{{ asset("assets/img/bg-masjid.jpg") }}') center/cover no-repeat;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* === TOMBOL BERANDA === */
.btn-beranda{
    position:fixed;
    top:20px;
    left:20px;
    background:#0a7c4a;
    color:#fff;
    padding:10px 16px;
    border-radius:8px;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    box-shadow:0 6px 18px rgba(0,0,0,.25);
    transition:.2s;
}
.btn-beranda:hover{
    background:#06653c;
}

/* === CARD === */
.card{
    width:420px;
    background:#fff;
    border-radius:14px;
    padding:40px;
    box-shadow:0 15px 40px rgba(0,0,0,.25);
}
.logo{
    width:90px;
    display:block;
    margin:0 auto 15px;
}
h2{
    text-align:center;
    color:#0a7c4a;
    margin-bottom:25px;
}
input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}
input:focus{
    outline:none;
    border-color:#0a7c4a;
    box-shadow:0 0 0 2px rgba(10,124,74,.2);
}
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#0a7c4a;
    color:#fff;
    font-weight:600;
    font-size:15px;
    cursor:pointer;
}
button:hover{background:#06653c}

.link{
    text-align:center;
    margin-top:15px;
    font-size:14px;
}
.link a{
    color:#0a7c4a;
    font-weight:600;
    text-decoration:none;
}
.link a:hover{
    text-decoration:underline;
}

.alert{
    background:#ffe0e0;
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
    color:#b30000;
    font-size:14px;
}
</style>
</head>

<body>

<!-- TOMBOL KE BERANDA -->
<a href="{{ route('welcome') }}" class="btn-beranda">← Beranda</a>

<div class="card">
    <img src="{{ asset('assets/img/logo.png') }}" class="logo">
    <h2>Daftar Akun</h2>

    @if(session('pesan'))
        <div class="alert">{{ session('pesan') }}</div>
    @endif

    @if($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('auth.register.post') }}">
        @csrf
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Ulangi Password" required>
        <button type="submit">Daftar</button>
    </form>

    <div class="link">
        <a href="{{ route('auth.login') }}">Kembali ke Login</a>
    </div>
</div>

</body>
</html>
