<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DailyDrive - Your Goals & Tasks Dashboard')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        // Custom neon colors
                        'neon-pink': '#e91e63',
                        'neon-purple': '#9c27b0',
                        'neon-green': '#4caf50',
                        'neon-blue': '#2196f3',
                        'neon-yellow': '#ff9800',
                        'neon-orange': '#f44336',
                        'neon-cyan': '#00bcd4',
                        'neon-teal': '#009688',

                        // Dark theme colors
                        'bg-primary': '#1a1a2e',
                        'bg-secondary': '#252542',
                        'bg-tertiary': '#2f2f4e',
                        'bg-card': '#252542',
                        'bg-hover': '#2f2f4e',
                        'bg-surface': '#353552',

                        // Text colors
                        'text-primary': '#f5f5f5',
                        'text-secondary': '#b0bec5',
                        'text-muted': '#64748b',
                        'text-accent': '#4caf50',
                    },
                    backgroundImage: {
                        'primary-gradient': 'linear-gradient(135deg, #e91e63 0%, #9c27b0 100%)',
                        'secondary-gradient': 'linear-gradient(135deg, #4caf50 0%, #2196f3 100%)',
                        'accent-gradient': 'linear-gradient(135deg, #ff9800 0%, #f44336 100%)',
                        'success-gradient': 'linear-gradient(135deg, #66bb6a 0%, #43a047 100%)',
                    },
                    fontFamily: {
                        'primary': ['"Inter"', '"SF Pro Display"', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'sans-serif'],
                        'display': ['"Clash Display"', '"Inter"', 'sans-serif'],
                        'mono': ['"JetBrains Mono"', '"Fira Code"', 'monospace'],
                    },
                    animation: {
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'float': 'float 6s ease-in-out infinite',
                        'shimmer': 'shimmer 2s infinite',
                    },
                    keyframes: {
                        glow: {
                            'from': { boxShadow: '0 0 5px #00bcd4' },
                            'to': { boxShadow: '0 0 20px #00bcd4, 0 0 30px #00bcd4' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(180deg)' },
                        },
                        shimmer: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(100%)' },
                        },
                    },
                },
            }
        }
    </script>

    <!-- Lucide Icons -->
    <link rel="stylesheet" href="https://unpkg.com/lucide-static@0.321.0/font/lucide.css">

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @stack('styles')
</head>

<body class="bg-bg-primary text-text-primary font-primary min-h-screen overflow-x-hidden">
    <!-- Include Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main class="py-4 pt-24">
        @yield('content')
    </main>

    <!-- Floating Chatbot Widget (Stage 8 - Gemini AI) -->
    @include('partials.chat-widget')

    <!-- Footer -->
    <footer class="bg-bg-secondary border-t border-border-color text-center py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-text-muted mb-0 font-primary">&copy; {{ date('Y') }} DailyDrive. Stay productive, stay
                    driven.</p>
                <div class="flex items-center gap-6 text-text-muted text-sm">
                    <span class="flex items-center gap-1">
                        <i class="lucide-heart text-neon-orange"></i>
                        Built with passion
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="lucide-zap text-neon-green"></i>
                        Level up your productivity
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Custom Scripts -->
    @stack('scripts')


</body>

</html>