@extends('layouts.app')

@section('title', 'Edit Goal')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 pt-24">
        <div class="max-w-4xl mx-auto">
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-neon-green to-neon-blue text-white p-6">
                    <h4 class="text-xl font-bold mb-0 font-display">
                        <i class="lucide-edit-2"></i> Edit Goal
                    </h4>
                </div>
                <div class="p-8">
                    <form action="{{ route('goals.update', $goal) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-text-secondary mb-2">
                                Goal Title <span class="text-neon-orange">*</span>
                            </label>
                            <input type="text" class="w-full px-4 py-3 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-neon-green/50 focus:border-neon-green transition-all duration-300 {{ $errors->has('title') ? 'border-red-500' : '' }}" id="title"
                                name="title" value="{{ old('title', $goal->title) }}" placeholder="Enter your goal title" required autofocus>
                        @error('title')
                            <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                                <i class="lucide-alert-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-text-secondary mb-2">
                                Description <span class="text-text-muted text-xs">(Optional)</span>
                            </label>
                            <textarea class="w-full px-4 py-3 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-neon-green/50 focus:border-neon-green transition-all duration-300 resize-none {{ $errors->has('description') ? 'border-red-500' : '' }}" id="description"
                                name="description" rows="4"
                                placeholder="Describe your goal and what you want to achieve...">{{ old('description', $goal->description) }}</textarea>
                        @error('description')
                            <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                                <i class="lucide-alert-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        </div>

                        <!-- Section Field -->
                        <div>
                            <label for="section" class="block text-sm font-medium text-text-secondary mb-2">
                                <i class="lucide-calendar text-neon-green"></i>
                                Time Period <span class="text-neon-orange">*</span>
                            </label>
                            <select id="section" name="section" required
                                class="w-full px-4 py-3 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary focus:outline-none focus:ring-2 focus:ring-neon-green/50 focus:border-neon-green transition-all duration-300 appearance-none cursor-pointer {{ $errors->has('section') ? 'border-red-500' : '' }}">
                                <option value="">Select a time period</option>
                                <option value="daily" {{ old('section', $goal->section) === 'daily' ? 'selected' : '' }}>
                                    Daily - Short-term goals for today
                                </option>
                                <option value="weekly" {{ old('section', $goal->section) === 'weekly' ? 'selected' : '' }}>
                                    Weekly - Goals to achieve this week
                                </option>
                                <option value="monthly" {{ old('section', $goal->section) === 'monthly' ? 'selected' : '' }}>
                                    Monthly - Long-term goals for the month
                                </option>
                            </select>
                            @error('section')
                                <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                                    <i class="lucide-alert-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <a href="{{ route('goals.index') }}" class="flex-1 px-6 py-3 bg-bg-secondary border border-border-color text-text-secondary rounded-xl hover:bg-bg-hover transition-colors duration-300 flex items-center justify-center gap-2">
                                <i class="lucide-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-neon-green to-neon-blue text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="lucide-check-circle"></i> Update Goal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Goal Info Card -->
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg mt-6">
                <h6 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                    <i class="lucide-info-circle text-neon-blue"></i> Goal Information
                </h6>
                <div class="space-y-2 text-text-secondary text-sm">
                    <div class="flex justify-between">
                        <span class="font-medium">Progress:</span>
                        <span class="text-neon-green font-semibold">{{ number_format($goal->progress, 0) }}%</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Total Tasks:</span>
                        <span class="text-neon-blue font-semibold">{{ $goal->tasks->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Created:</span>
                        <span>{{ $goal->created_at->format('F j, Y \a\t g:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Last Updated:</span>
                        <span>{{ $goal->updated_at->format('F j, Y \a\t g:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
