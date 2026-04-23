@extends('layouts.auth')

@section('title', 'Login - DailyDrive')

@section('content')
<div class="min-h-screen bg-gray-950 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full opacity-20 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-blue-500 to-cyan-400 rounded-full opacity-20 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-gradient-to-r from-orange-400 to-red-500 rounded-full opacity-10 blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl shadow-2xl mb-4 relative">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl blur-lg opacity-50 animate-pulse"></div>
                <i class="lucide-zap text-white text-3xl relative z-10"></i>
            </div>
            <h1 class="text-4xl font-black text-white mb-2 bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                DailyDrive
            </h1>
            <p class="text-gray-400 text-lg">Level up your productivity</p>
        </div>

        <!-- Login Form -->
        <div class="bg-gray-900/80 backdrop-blur-xl border border-gray-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <!-- Animated Border -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-pink-500 to-purple-600 animate-pulse"></div>
            
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white mb-2">Welcome Back</h2>
                <p class="text-gray-400">Ready to crush your goals today?</p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center gap-3 text-green-400">
                    <i class="lucide-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="flex items-center gap-2 text-gray-300 text-sm font-medium mb-2">
                        <i class="lucide-mail text-pink-400"></i>
                        Email Address
                    </label>
                    <div class="relative">
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            class="w-full pl-12 pr-4 py-4 bg-gray-800/80 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500 transition-all duration-300"
                            placeholder="you@example.com"
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-pink-500 to-purple-600 rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                    </div>
                    @error('email')
                        <div class="mt-2 flex items-center gap-2 text-red-400 text-sm">
                            <i class="lucide-alert-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="flex items-center gap-2 text-gray-300 text-sm font-medium mb-2">
                        <i class="lucide-lock text-pink-400"></i>
                        Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            class="w-full pl-12 pr-4 py-4 bg-gray-800/80 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500 transition-all duration-300"
                            placeholder="Enter your password"
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-pink-500 to-purple-600 rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                    </div>
                    @error('password')
                        <div class="mt-2 flex items-center gap-2 text-red-400 text-sm">
                            <i class="lucide-alert-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-3 text-gray-400 text-sm cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-pink-500 bg-gray-800 border-gray-600 rounded focus:ring-pink-500 focus:ring-2">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-pink-400 hover:text-pink-300 text-sm transition-colors">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-pink-500/25 transition-all duration-300 flex items-center justify-center gap-3 group relative overflow-hidden">
                    <span class="relative z-10">Sign In</span>
                    <i class="lucide-arrow-right relative z-10 group-hover:translate-x-1 transition-transform duration-300"></i>
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-500 to-purple-600 opacity-0 group-hover:opacity-100 blur-lg transition-opacity duration-300"></div>
                </button>
            </form>

            <!-- Register Link -->
            <div class="text-center mt-6 pt-6 border-t border-gray-800">
                <p class="text-gray-400 text-sm">
                    New to the game?
                    <a href="{{ route('register') }}" class="text-pink-400 hover:text-pink-300 font-semibold ml-1 transition-colors">
                        Create Account
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-600 text-xs">© {{ date('Y') }} DailyDrive — Built for go-getters</p>
        </div>
    </div>
</div>
