@extends('layouts.auth')

@section('title', 'Register - DailyDrive')

@section('content')
<div class="min-h-screen bg-gray-950 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-green-400 to-blue-500 rounded-full opacity-20 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-yellow-400 to-orange-500 rounded-full opacity-20 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full opacity-10 blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl shadow-2xl mb-4 relative">
                <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl blur-lg opacity-50 animate-pulse"></div>
                <i class="lucide-rocket text-white text-3xl relative z-10"></i>
            </div>
            <h1 class="text-4xl font-black text-white mb-2 bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">
                DailyDrive
            </h1>
            <p class="text-gray-400 text-lg">Join the productivity revolution</p>
        </div>

        <!-- Register Form -->
        <div class="bg-gray-900/80 backdrop-blur-xl border border-gray-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <!-- Animated Border -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-green-400 to-blue-500 animate-pulse"></div>
            
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white mb-2">Create Account</h2>
                <p class="text-gray-400">Start your journey to greatness</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="flex items-center gap-2 text-gray-300 text-sm font-medium mb-2">
                        <i class="lucide-user text-green-400"></i>
                        Full Name
                    </label>
                    <div class="relative">
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            class="w-full pl-12 pr-4 py-4 bg-gray-800/80 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400/50 focus:border-green-400 transition-all duration-300"
                            placeholder="John Doe"
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                    </div>
                    @error('name')
                        <div class="mt-2 flex items-center gap-2 text-red-400 text-sm">
                            <i class="lucide-alert-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="flex items-center gap-2 text-gray-300 text-sm font-medium mb-2">
                        <i class="lucide-mail text-green-400"></i>
                        Email Address
                    </label>
                    <div class="relative">
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            class="w-full pl-12 pr-4 py-4 bg-gray-800/80 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400/50 focus:border-green-400 transition-all duration-300"
                            placeholder="you@example.com"
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
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
                        <i class="lucide-lock text-green-400"></i>
                        Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            class="w-full pl-12 pr-4 py-4 bg-gray-800/80 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400/50 focus:border-green-400 transition-all duration-300"
                            placeholder="Create a strong password"
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                    </div>
                    @error('password')
                        <div class="mt-2 flex items-center gap-2 text-red-400 text-sm">
                            <i class="lucide-alert-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="flex items-center gap-2 text-gray-300 text-sm font-medium mb-2">
                        <i class="lucide-shield-check text-green-400"></i>
                        Confirm Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            class="w-full pl-12 pr-4 py-4 bg-gray-800/80 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400/50 focus:border-green-400 transition-all duration-300"
                            placeholder="Confirm your password"
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-green-400 to-blue-500 text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-green-400/25 transition-all duration-300 flex items-center justify-center gap-3 group relative overflow-hidden mt-6">
                    <span class="relative z-10">Create Account</span>
                    <i class="lucide-sparkles relative z-10 group-hover:rotate-180 transition-transform duration-500"></i>
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 opacity-0 group-hover:opacity-100 blur-lg transition-opacity duration-300"></div>
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6 pt-6 border-t border-gray-800">
                <p class="text-gray-400 text-sm">
                    Already part of the crew?
                    <a href="{{ route('login') }}" class="text-green-400 hover:text-green-300 font-semibold ml-1 transition-colors">
                        Sign In
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-600 text-xs">© {{ date('Y') }} DailyDrive — Built for achievers</p>
        </div>
    </div>
</div>
