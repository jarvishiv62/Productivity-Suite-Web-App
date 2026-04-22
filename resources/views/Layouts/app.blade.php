<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DailyDrive - Your Goals & Tasks Dashboard')</title>

    <!-- Custom GenZ CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Lucide Icons -->
    <link rel="stylesheet" href="https://unpkg.com/lucide-static@0.321.0/font/lucide.css">

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @stack('styles')
</head>

<body>
    <!-- Include Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Floating Chatbot Widget (Stage 8 - Gemini AI) -->
    @include('partials.chat-widget')

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-5">
        <div class="container">
            <p class="text-muted mb-0">&copy; {{ date('Y') }} DailyDrive. Stay productive, stay driven.</p>
        </div>
    </footer>

    <!-- Custom Scripts -->
    @stack('scripts')


</body>

</html>