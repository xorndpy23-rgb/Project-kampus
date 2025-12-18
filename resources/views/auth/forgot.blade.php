<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Masjid Al-Muttaqin | Lupa Password</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{box-sizing:border-box}
body{
    margin:0;
    font-family:'Inter',sans-serif;
    min-height:100vh;
    background:
      linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.55)),
      url('{{ asset("assets/img/2.png") }}') center/cover no-repeat;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* tombol beranda */
.back-home{
    position:absolute;
    top:20px;
    left:20px;
}
.back-home a{
    background:#ffffffdd;
    padding:8px 14px;
    border-radius:20px;
    text-decoration:none;
    color:#0a7c4a;
    font-weight:600;
    font-size:14px;
}

/* card */
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
}
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#0a7c4a;
    color:#fff;
    font-weight:600;
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

.alert{
    background:#ffe0e0;
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
    color:#b30000;
    font-size:14px;
}
.success{
    background:#e0ffe8;
    color:#0a7c4a;
}
</style>
</head>
<body>

<div class="back-home">
    <a href="{{ route('welcome') }}">← Beranda</a>
</div>

<div class="card">
    <img src="{{ asset('assets/img/logo.png') }}" class="logo">
    <h2>Lupa Password</h2>

    @if(session('pesan'))
        <div class="alert success">{{ session('pesan') }}</div>
    @endif

    @if($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="Masukkan Email Terdaftar" required>
        <button>Kirim Link Reset</button>
    </form>

    <div class="link">
        <a href="{{ route('auth.login') }}">Kembali ke Login</a>
    </div>
</div>

</body>
</html>
