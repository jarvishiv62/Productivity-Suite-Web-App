@extends('layouts.app')

@section('title', 'New Diary Entry')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 pt-24">
        <div class="max-w-4xl mx-auto">
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-neon-purple to-neon-pink text-white p-6">
                    <h4 class="text-xl font-bold mb-0 font-display">
                        <i class="lucide-journal-plus"></i> New Diary Entry
                    </h4>
                </div>
                <div class="p-8">
                    <form action="{{ route('diary.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Date Field -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-text-secondary mb-2">
                                <i class="lucide-calendar text-neon-purple"></i>
                                Date <span class="text-neon-orange">*</span>
                            </label>
                            <input type="date" class="w-full px-4 py-3 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary focus:outline-none focus:ring-2 focus:ring-neon-purple/50 focus:border-neon-purple transition-all duration-300 {{ $errors->has('date') ? 'border-red-500' : '' }}" id="date"
                                name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                                    <i class="lucide-alert-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="text-text-muted text-xs mt-2 flex items-center gap-1">
                                <i class="lucide-info-circle"></i>
                                Select the date for this diary entry
                            </p>
                        </div>

                        <!-- Title Field -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-text-secondary mb-2">
                                <i class="lucide-edit-3 text-neon-purple"></i>
                                Title <span class="text-neon-orange">*</span>
                            </label>
                            <input type="text" class="w-full px-4 py-3 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-neon-purple/50 focus:border-neon-purple transition-all duration-300 {{ $errors->has('title') ? 'border-red-500' : '' }}" id="title"
                                name="title" value="{{ old('title') }}" placeholder="What's on your mind today?" required autofocus>
                            @error('title')
                                <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                                    <i class="lucide-alert-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Content Field -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-text-secondary mb-2">
                                <i class="lucide-file-text text-neon-purple"></i>
                                Content <span class="text-neon-orange">*</span>
                            </label>
                            <textarea class="w-full px-4 py-3 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-neon-purple/50 focus:border-neon-purple transition-all duration-300 resize-none {{ $errors->has('content') ? 'border-red-500' : '' }}" id="content"
                                name="content" rows="15"
                                placeholder="Write your thoughts, feelings, and experiences here..."
                                required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                                    <i class="lucide-alert-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="text-text-muted text-xs mt-2 flex items-center gap-1">
                                <i class="lucide-info-circle"></i>
                                Express yourself freely - this is your personal space
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <a href="{{ route('diary.index') }}" class="flex-1 px-6 py-3 bg-bg-secondary border border-border-color text-text-secondary rounded-xl hover:bg-bg-hover transition-colors duration-300 flex items-center justify-center gap-2">
                                <i class="lucide-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-neon-purple to-neon-pink text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="lucide-save"></i> Save Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Writing Tips Card -->
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg mt-6">
                <h6 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                    <i class="lucide-lightbulb text-neon-yellow"></i> Journaling Tips
                </h6>
                <ul class="space-y-2 text-text-secondary text-sm">
                    <li class="flex items-start gap-2">
                        <i class="lucide-check-circle text-neon-purple mt-0.5"></i>
                        Write honestly - this is for your eyes only
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="lucide-check-circle text-neon-purple mt-0.5"></i>
                        Include details about your day, thoughts, and feelings
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="lucide-check-circle text-neon-purple mt-0.5"></i>
                        Reflect on what you learned or experienced
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="lucide-check-circle text-neon-purple mt-0.5"></i>
                        Note things you're grateful for
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="lucide-check-circle text-neon-purple mt-0.5"></i>
                        Set intentions for tomorrow
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
