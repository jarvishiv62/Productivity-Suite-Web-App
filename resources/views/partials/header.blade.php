<!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-[1000] bg-bg-secondary border-b border-border-color py-4 backdrop-blur-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 text-decoration-none font-bold text-xl text-text-primary hover:text-neon-cyan transition-colors duration-200">
                🚀
                <span
                    class="bg-gradient-to-r from-neon-pink to-neon-purple bg-clip-text text-transparent">DailyDrive</span>
            </a>

            <!-- Mobile Menu Toggle -->
            <button id="mobileMenuToggle"
                class="hidden bg-transparent border-none text-text-primary text-xl cursor-pointer p-2 md:hidden">
                🍔
                <i class="lucide-menu"></i>
            </button>

            <!-- Desktop Navigation -->
            <div id="desktopNav" class="hidden md:flex items-center gap-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-text-secondary hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'bg-bg-hover text-neon-cyan' : '' }}">
                        <i class="lucide-activity"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('goals.index') }}"
                        class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-text-secondary hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 {{ request()->routeIs('goals.*') ? 'bg-bg-hover text-neon-cyan' : '' }}">
                        🎯
                        <span>Goals</span>
                    </a>

                    <a href="{{ route('tasks.index') }}"
                        class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-text-secondary hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 {{ request()->routeIs('tasks.index') ? 'bg-bg-hover text-neon-cyan' : '' }}">
                        📋
                        <span>All Tasks</span>
                    </a>

                    <a href="{{ route('diary.index') }}"
                        class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-text-secondary hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 {{ request()->routeIs('diary.*') ? 'bg-bg-hover text-neon-cyan' : '' }}">
                        📖
                        <span>Diary</span>
                    </a>

                    <a href="{{ route('calendar.index') }}"
                        class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-text-secondary hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 {{ request()->routeIs('calendar.*') ? 'bg-bg-hover text-neon-cyan' : '' }}">
                        📅
                        <span>Calendar</span>
                    </a>

                    <a href="{{ route('pomodoro.index') }}"
                        class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-text-secondary hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300">
                        ⏰
                        <span>Pomodoro</span>
                    </a>

                    <a href="{{ route('progress.index') }}"
                        class="nav-link flex items-center gap-2 px-3 py-2 rounded-lg text-text-secondary hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 {{ request()->routeIs('progress.*') ? 'bg-bg-hover text-neon-cyan' : '' }}">
                        📈
                        <span>Progress</span>
                    </a>
                </div>

                @auth
                    <!-- User Dropdown -->
                    <div class="relative">
                        <button id="userDropdownToggle"
                            class="flex items-center gap-2 px-3 py-2 border border-neon-cyan rounded-lg bg-transparent text-neon-cyan cursor-pointer hover:bg-neon-cyan hover:text-bg-primary transition-all duration-300">
                            <i class="lucide-user"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="lucide-chevron-down text-sm"></i>
                        </button>

                        <div id="userDropdown"
                            class="hidden absolute top-full right-0 mt-1 bg-bg-card border border-border-color rounded-lg shadow-lg min-w-[200px] z-[1000]">
                            <a href="#"
                                class="flex items-center gap-2 p-4 text-text-primary hover:bg-bg-hover transition-colors duration-200">
                                <i class="lucide-user"></i>
                                <span>Profile</span>
                            </a>

                            <div class="h-px bg-border-color my-2"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-2 w-full p-4 bg-transparent border-none text-text-primary cursor-pointer hover:bg-bg-hover transition-colors duration-200 text-left">
                                    <i class="lucide-log-out"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Login/Register Buttons -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}"
                            class="btn btn-outline flex items-center gap-2 px-3 py-2 border-2 border-neon-cyan text-neon-cyan rounded-lg hover:bg-neon-cyan hover:text-bg-primary transition-all duration-300">
                            <i class="lucide-log-in"></i> Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="btn btn-secondary flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                                <i class="lucide-user-plus"></i> Register
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobileNav" class="hidden mt-4 pt-4 border-t border-border-color md:hidden">
            <div class="flex flex-col gap-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 p-4 text-text-primary hover:bg-bg-hover rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'bg-bg-hover' : '' }}">
                    <i class="lucide-activity"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('goals.index') }}"
                    class="flex items-center gap-2 p-4 text-text-primary hover:bg-bg-hover rounded-lg transition-colors duration-200 {{ request()->routeIs('goals.*') ? 'bg-bg-hover' : '' }}">
                    <i class="lucide-target"></i>
                    <span>Goals</span>
                </a>

                <a href="{{ route('tasks.index') }}"
                    class="flex items-center gap-2 p-4 text-text-primary hover:bg-bg-hover rounded-lg transition-colors duration-200 {{ request()->routeIs('tasks.index') ? 'bg-bg-hover' : '' }}">
                    <i class="lucide-list-checks"></i>
                    <span>All Tasks</span>
                </a>

                <a href="{{ route('diary.index') }}"
                    class="flex items-center gap-2 p-4 text-text-primary hover:bg-bg-hover rounded-lg transition-colors duration-200 {{ request()->routeIs('diary.*') ? 'bg-bg-hover' : '' }}">
                    <i class="lucide-book-open"></i>
                    <span>Diary</span>
                </a>

                <a href="{{ route('calendar.index') }}"
                    class="flex items-center gap-2 p-4 text-text-primary hover:bg-bg-hover rounded-lg transition-colors duration-200 {{ request()->routeIs('calendar.*') ? 'bg-bg-hover' : '' }}">
                    <i class="lucide-calendar"></i>
                    <span>Calendar</span>
                </a>

                <a href="{{ route('pomodoro.index') }}"
                    class="flex items-center gap-2 p-4 text-text-primary hover:bg-bg-hover rounded-lg transition-colors duration-200">
                    <i class="lucide-timer"></i>
                    <span>Pomodoro</span>
                </a>

                <a href="{{ route('progress.index') }}"
                    class="flex items-center gap-2 p-4 text-text-primary hover:bg-bg-hover rounded-lg transition-colors duration-200 {{ request()->routeIs('progress.*') ? 'bg-bg-hover' : '' }}">
                    <i class="lucide-trending-up"></i>
                    <span>Progress</span>
                </a>

                @auth
                    <div class="h-px bg-border-color my-2"></div>
                    <a href="#"
                        class="flex items-center gap-2 p-4 text-text-primary hover:bg-bg-hover rounded-lg transition-colors duration-200">
                        <i class="lucide-user"></i>
                        <span>Profile</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 w-full p-4 bg-transparent border-none text-text-primary cursor-pointer hover:bg-bg-hover transition-colors duration-200 text-left">
                            <i class="lucide-log-out"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                @else
                    <div class="h-px bg-border-color my-2"></div>
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-2 p-4 text-neon-cyan hover:bg-bg-hover rounded-lg transition-colors duration-200">
                        <i class="lucide-log-in"></i>
                        <span>Login</span>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="flex items-center gap-2 p-4 text-neon-cyan hover:bg-bg-hover rounded-lg transition-colors duration-200">
                            <i class="lucide-user-plus"></i>
                            <span>Register</span>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Flash Messages -->
@if(session('success'))
    <div class="py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div
                class="bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary p-4 rounded-lg flex items-center gap-2 animate-fade-in">
                <i class="lucide-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-neon-orange text-white p-4 rounded-lg flex items-center gap-2 animate-fade-in">
                <i class="lucide-alert-triangle"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    </div>
@endif

<style>
    /* Navigation hover effects - Tailwind handles most of these */
    .nav-link:hover {
        background: var(--bg-hover) !important;
        color: var(--neon-cyan) !important;
    }

    .nav-link.active {
        background: var(--bg-hover) !important;
        color: var(--neon-cyan) !important;
    }

    #userDropdownToggle:hover {
        background: var(--neon-cyan) !important;
        color: var(--bg-primary) !important;
    }

    #userDropdown a:hover {
        background: var(--bg-hover) !important;
    }

    #userDropdown button:hover {
        background: var(--bg-hover) !important;
    }

    /* Mobile responsiveness - Tailwind handles most of these */
    @media (max-width: 768px) {
        #desktopNav {
            display: none !important;
        }

        #mobileMenuToggle {
            display: block !important;
        }

        #mobileNav.show {
            display: block !important;
        }
    }

    @media (min-width: 769px) {
        #mobileNav {
            display: none !important;
        }
    }

    /* Custom animations for flash messages */
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }

        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }
</style>

<script>
    // Mobile menu toggle
    document.getElementById('mobileMenuToggle')?.addEventListener('click', function () {
        const mobileNav = document.getElementById('mobileNav');
        mobileNav.classList.toggle('show');
    });

    // User dropdown toggle
    document.getElementById('userDropdownToggle')?.addEventListener('click', function (e) {
        e.stopPropagation();
        const dropdown = document.getElementById('userDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function () {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown) {
            dropdown.style.display = 'none';
        }
    });

    // Prevent dropdown from closing when clicking inside it
    document.getElementById('userDropdown')?.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Auto-hide flash messages after 5 seconds
    setTimeout(() => {
        const flashMessages = document.querySelectorAll('[style*="animation: slideInRight"]');
        flashMessages.forEach(msg => {
            msg.style.animation = 'slideOutRight 0.3s ease forwards';
            setTimeout(() => msg.remove(), 300);
        });
    }, 5000);
</script>