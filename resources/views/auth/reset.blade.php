<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body{margin:0;font-family:Inter;background:#f5f7fa}
        .box{min-height:100vh;display:flex;justify-content:center;align-items:center}
        .card{width:420px;background:#fff;padding:35px;border-radius:14px}
        input,button{width:100%;padding:12px;margin-bottom:15px}
        button{background:#067953;color:#fff;border:none}
        .link{text-align:center}
    </style>
</head>
<body>
<div class="box">
    <div class="card">
        <h2>Reset Password</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password Baru" required>
            <input type="password" name="password_confirmation" placeholder="Ulangi Password" required>
            <button>Reset Password</button>
        </form>

        <div class="link"><a href="{{ route('auth.login') }}">Login</a></div>
        <div class="link"><a href="{{ route('welcome') }}">← Beranda</a></div>
    </div>
</div>
</body>
</html>
