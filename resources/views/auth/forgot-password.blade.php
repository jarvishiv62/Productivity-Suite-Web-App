@extends('layouts.auth')

@section('content')
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="mx-auto h-20 w-20 rounded-full flex items-center justify-center mb-6 glow-animation"
                style="background: var(--accent-gradient);">
                <i class="lucide-key text-3xl text-white"></i>
            </div>
            <h1 class="text-4xl font-bold mb-2"
                style="background: var(--accent-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Forgot Password?</h1>
            <p class="text-lg" style="color: var(--text-secondary);">No problem. We'll send you a reset link.</p>
        </div>

        <!-- Forgot Password Form Card -->
        <div class="relative"
            style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; padding: 2rem; box-shadow: var(--shadow-lg);">
            <!-- Glow Effect -->
            <div class="absolute inset-0 rounded-2xl opacity-50"
                style="background: var(--shadow-neon); filter: blur(20px); z-index: -1;"></div>
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-lg flex items-center"
                    style="background: var(--neon-green-muted); border: 1px solid var(--neon-green);">
                    <i class="lucide-check-circle mr-3" style="color: var(--neon-green);"></i>
                    <span style="color: var(--text-primary);" class="font-medium">{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Email
                        Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="lucide-mail text-lg" style="color: var(--text-muted);"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-3 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 transition-all"
                            style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); focus:ring-color: var(--neon-green); focus:border-color: var(--neon-green); focus:background: var(--bg-hover);"
                            placeholder="you@example.com">
                    </div>
                    @error('email')
                        <p class="mt-2 flex items-center text-sm" style="color: var(--neon-orange);">
                            <i class="lucide-alert-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 text-sm font-semibold rounded-lg text-white transition-all transform hover:scale-105 focus:outline-none focus:ring-2 glow-animation"
                        style="background: var(--accent-gradient); border: none; focus:ring-color: var(--neon-green);">
                        <i class="lucide-send mr-2"></i>
                        Send Password Reset Link
                    </button>
                </div>
            </form>

            <!-- Back to Login Link -->
            <div class="mt-6 text-center pt-6" style="border-top: 1px solid var(--border-color);">
                <p class="text-sm" style="color: var(--text-secondary);">
                    Remember your password?
                    <a href="{{ route('login') }}" class="font-medium transition-colors hover:underline ml-1"
                        style="color: var(--neon-blue);">
                        Back to sign in
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-xs" style="color: var(--text-muted);">
                &copy; {{ date('Y') }} DailyDrive. Stay productive, stay driven.
            </p>
        </div>
    </div>
@endsection