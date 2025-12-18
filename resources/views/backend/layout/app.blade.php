<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Masjid Al-Muttaqin')</title>

    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    @stack('styles')
</head>
<body>

    @yield('content')

    @stack('scripts')
</body>
</html>
