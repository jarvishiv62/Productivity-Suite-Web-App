<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DailyDrive - Your Goals & Tasks Dashboard')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <link rel="stylesheet" href="https://unpkg.com/lucide-static@0.321.0/font/lucide.css">
    
    <!-- Custom GenZ CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>

<body style="margin: 0; padding: 0; overflow-x: hidden;">
    @yield('content')

    <!-- Custom Scripts -->
    @stack('scripts')
</body>

</html>