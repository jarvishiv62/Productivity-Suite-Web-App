<!-- Navigation -->
<nav
    style="background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); padding: var(--space-md) 0; position: sticky; top: 0; z-index: 1000; backdrop-filter: blur(10px);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}"
                style="display: flex; align-items: center; gap: var(--space-sm); text-decoration: none; font-weight: 700; font-size: 1.5rem; color: var(--text-primary);">
                🚀
                <span
                    style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">DailyDrive</span>
            </a>

            <!-- Mobile Menu Toggle -->
            <button id="mobileMenuToggle"
                style="display: none; background: none; border: none; color: var(--text-primary); font-size: 1.5rem; cursor: pointer; padding: var(--space-sm);">
                🍔
                <i class="lucide-menu"></i>
            </button>

            <!-- Desktop Navigation -->
            <div id="desktopNav" style="display: flex; align-items: center; gap: var(--space-lg);">
                <div style="display: flex; align-items: center; gap: var(--space-md);">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); transition: var(--transition-normal); {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'background: var(--bg-hover); color: var(--neon-cyan);' : '' }}">
                        <i class="lucide-activity"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('goals.index') }}"
                        class="nav-link {{ request()->routeIs('goals.*') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); transition: var(--transition-normal); {{ request()->routeIs('goals.*') ? 'background: var(--bg-hover); color: var(--neon-cyan);' : '' }}">
                        🎯
                        <span>Goals</span>
                    </a>

                    <a href="{{ route('tasks.index') }}"
                        class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); transition: var(--transition-normal); {{ request()->routeIs('tasks.index') ? 'background: var(--bg-hover); color: var(--neon-cyan);' : '' }}">
                        📋
                        <span>All Tasks</span>
                    </a>

                    <a href="{{ route('diary.index') }}"
                        class="nav-link {{ request()->routeIs('diary.*') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); transition: var(--transition-normal); {{ request()->routeIs('diary.*') ? 'background: var(--bg-hover); color: var(--neon-cyan);' : '' }}">
                        📖
                        <span>Diary</span>
                    </a>

                    <a href="{{ route('calendar.index') }}"
                        class="nav-link {{ request()->routeIs('calendar.*') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); transition: var(--transition-normal); {{ request()->routeIs('calendar.*') ? 'background: var(--bg-hover); color: var(--neon-cyan);' : '' }}">
                        📅
                        <span>Calendar</span>
                    </a>

                    <a href="{{ route('pomodoro.index') }}" class="nav-link"
                        style="display: flex; align-items: center; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); transition: var(--transition-normal);">
                        ⏰
                        <span>Pomodoro</span>
                    </a>

                    <a href="{{ route('progress.index') }}"
                        class="nav-link {{ request()->routeIs('progress.*') ? 'active' : '' }}"
                        style="display: flex; align-items: center; gap: var(--space-xs); padding: var(--space-sm) var(--space-md); border-radius: var(--radius-md); text-decoration: none; color: var(--text-secondary); transition: var(--transition-normal); {{ request()->routeIs('progress.*') ? 'background: var(--bg-hover); color: var(--neon-cyan);' : '' }}">
                        📈
                        <span>Progress</span>
                    </a>
                </div>

                @auth
                    <!-- User Dropdown -->
                    <div style="position: relative;">
                        <button id="userDropdownToggle"
                            style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-sm) var(--space-md); border: 1px solid var(--neon-cyan); border-radius: var(--radius-md); background: transparent; color: var(--neon-cyan); cursor: pointer; transition: var(--transition-normal);">
                            <i class="lucide-user"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="lucide-chevron-down" style="font-size: 0.8rem;"></i>
                        </button>

                        <div id="userDropdown"
                            style="display: none; position: absolute; top: 100%; right: 0; margin-top: var(--space-xs); background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); box-shadow: var(--shadow-lg); min-width: 200px; z-index: 1000;">
                            <a href="#"
                                style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--text-primary); text-decoration: none; transition: var(--transition-fast);">
                                <i class="lucide-user"></i>
                                <span>Profile</span>
                            </a>

                            <div style="height: 1px; background: var(--border-color); margin: var(--space-xs) 0;"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    style="display: flex; align-items: center; gap: var(--space-sm); width: 100%; padding: var(--space-md); background: none; border: none; color: var(--text-primary); cursor: pointer; transition: var(--transition-fast);">
                                    <i class="lucide-log-out"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Login/Register Buttons -->
                    <div style="display: flex; align-items: center; gap: var(--space-sm);">
                        <a href="{{ route('login') }}" class="btn btn-outline">
                            <i class="lucide-log-in"></i> Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">
                                <i class="lucide-user-plus"></i> Register
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobileNav"
            style="display: none; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid var(--border-color);">
            <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
                <a href="{{ route('dashboard') }}"
                    style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--text-primary); text-decoration: none; border-radius: var(--radius-md); {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'background: var(--bg-hover);' : '' }}">
                    <i class="lucide-activity"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('goals.index') }}"
                    style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--text-primary); text-decoration: none; border-radius: var(--radius-md); {{ request()->routeIs('goals.*') ? 'background: var(--bg-hover);' : '' }}">
                    <i class="lucide-target"></i>
                    <span>Goals</span>
                </a>

                <a href="{{ route('tasks.index') }}"
                    style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--text-primary); text-decoration: none; border-radius: var(--radius-md); {{ request()->routeIs('tasks.index') ? 'background: var(--bg-hover);' : '' }}">
                    <i class="lucide-list-checks"></i>
                    <span>All Tasks</span>
                </a>

                <a href="{{ route('diary.index') }}"
                    style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--text-primary); text-decoration: none; border-radius: var(--radius-md); {{ request()->routeIs('diary.*') ? 'background: var(--bg-hover);' : '' }}">
                    <i class="lucide-book-open"></i>
                    <span>Diary</span>
                </a>

                <a href="{{ route('calendar.index') }}"
                    style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--text-primary); text-decoration: none; border-radius: var(--radius-md); {{ request()->routeIs('calendar.*') ? 'background: var(--bg-hover);' : '' }}">
                    <i class="lucide-calendar"></i>
                    <span>Calendar</span>
                </a>

                <a href="{{ route('pomodoro.index') }}"
                    style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--text-primary); text-decoration: none; border-radius: var(--radius-md);">
                    <i class="lucide-timer"></i>
                    <span>Pomodoro</span>
                </a>

                <a href="{{ route('progress.index') }}"
                    style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--text-primary); text-decoration: none; border-radius: var(--radius-md); {{ request()->routeIs('progress.*') ? 'background: var(--bg-hover);' : '' }}">
                    <i class="lucide-trending-up"></i>
                    <span>Progress</span>
                </a>

                @auth
                    <div style="height: 1px; background: var(--border-color); margin: var(--space-sm) 0;"></div>
                    <a href="#"
                        style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--text-primary); text-decoration: none; border-radius: var(--radius-md);">
                        <i class="lucide-user"></i>
                        <span>Profile</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            style="display: flex; align-items: center; gap: var(--space-sm); width: 100%; padding: var(--space-md); background: none; border: none; color: var(--text-primary); cursor: pointer; text-align: left;">
                            <i class="lucide-log-out"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                @else
                    <div style="height: 1px; background: var(--border-color); margin: var(--space-sm) 0;"></div>
                    <a href="{{ route('login') }}"
                        style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--neon-cyan); text-decoration: none; border-radius: var(--radius-md);">
                        <i class="lucide-log-in"></i>
                        <span>Login</span>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            style="display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-md); color: var(--neon-cyan); text-decoration: none; border-radius: var(--radius-md);">
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
    <div style="padding: var(--space-md) 0;">
        <div class="container">
            <div
                style="background: var(--secondary-gradient); color: var(--bg-primary); padding: var(--space-md); border-radius: var(--radius-md); display: flex; align-items: center; gap: var(--space-sm); animation: slideInRight 0.3s ease;">
                <i class="lucide-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div style="padding: var(--space-md) 0;">
        <div class="container">
            <div
                style="background: var(--neon-orange); color: white; padding: var(--space-md); border-radius: var(--radius-md); display: flex; align-items: center; gap: var(--space-sm); animation: slideInRight 0.3s ease;">
                <i class="lucide-alert-triangle"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    </div>
@endif

<style>
    /* Navigation hover effects */
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

    /* Mobile responsiveness */
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