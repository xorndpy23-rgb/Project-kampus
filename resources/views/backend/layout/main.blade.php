<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Admin Panel')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { background:#f5f7fb; font-family:'Segoe UI',sans-serif; }
        .sidebar {
            width:260px;height:100vh;position:fixed;
            background:linear-gradient(180deg,#0A9E48,#067a39);
            color:white;
        }
        .sidebar a {
            display:flex;gap:12px;padding:12px 22px;
            color:#e6ffe7;text-decoration:none;
        }
        .sidebar a.active, .sidebar a:hover {
            background:rgba(255,255,255,.2);
            font-weight:600;
        }
        .navbar-custom {
            margin-left:260px;height:65px;background:white;
            display:flex;align-items:center;padding:0 30px;
            box-shadow:0 2px 10px rgba(0,0,0,.05);
        }
        .content { margin-left:260px;padding:30px; }
        .card-box {
            border:none;border-radius:16px;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
        }
    </style>
</head>
<body>

@include('backend.partials.sidebar')
@include('backend.partials.navbar')

<main class="content">
    @yield('content')
</main>

</body>
</html>
