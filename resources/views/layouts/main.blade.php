<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    

        <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#dc2626">

    <link rel="icon" href="{{ asset('icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">
    <script src="https://kit.fontawesome.com/7f4731297f.js" crossorigin="anonymous"></script>

    <title>Telkomsel Report</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-red-700 via-red-600 to-orange-400 text-gray-900">
    @yield('content')
</body>
</html>
