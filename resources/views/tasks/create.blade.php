@extends('layouts.app')

@section('title', 'Create New Task')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 pt-24">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-neon-blue to-neon-purple rounded-2xl shadow-2xl mb-4 relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-neon-blue to-neon-purple rounded-2xl blur-lg opacity-50 animate-pulse">
                </div>
                <i class="lucide-plus text-white text-2xl relative z-10"></i>
            </div>
            <h1 class="text-3xl font-bold text-text-primary mb-2">Create New Task</h1>
            <p class="text-text-secondary">Add a new task to crush your goals</p>
        </div>

        <!-- Form Container -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-3xl p-8 shadow-2xl">
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title Field -->
                <div>
                    <label for="title" class="flex items-center gap-2 text-text-secondary text-sm font-medium mb-2">
                        <i class="lucide-target text-neon-cyan"></i>
                        Task Title <span class="text-neon-orange">*</span>
                    </label>
                    <div class="relative">
                        <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus
                            class="w-full px-4 py-4 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-neon-cyan/50 focus:border-neon-cyan transition-all duration-300"
                            placeholder="Enter task title">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-neon-blue to-neon-purple rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10">
                        </div>
                    </div>
                    @error('title')
                        <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                            <i class="lucide-alert-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Description Field -->
                <div>
                    <label for="description"
                        class="flex items-center gap-2 text-text-secondary text-sm font-medium mb-2">
                        <i class="lucide-file-text text-neon-cyan"></i>
                        Description <span class="text-text-muted">(Optional)</span>
                    </label>
                    <div class="relative">
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-4 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-neon-cyan/50 focus:border-neon-cyan transition-all duration-300 resize-none"
                            placeholder="Add any additional details about this task...">{{ old('description') }}</textarea>
                        <div class="absolute inset-0 bg-gradient-to-r from-neon-blue to-neon-purple rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                    </div>
                    @error('description')
                        <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                            <i class="lucide-alert-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Section Field -->
                <div>
                    <label for="section" class="flex items-center gap-2 text-text-secondary text-sm font-medium mb-2">
                        <i class="lucide-calendar text-neon-cyan"></i>
                        Time Period <span class="text-neon-orange">*</span>
                    </label>
                    <div class="relative">
                        <select id="section" name="section" required
                            class="w-full px-4 py-4 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary focus:outline-none focus:ring-2 focus:ring-neon-cyan/50 focus:border-neon-cyan transition-all duration-300 appearance-none cursor-pointer">
                            <option value="">Select a time period</option>
                            <option value="daily" {{ old('section', request('section')) === 'daily' ? 'selected' : '' }}>
                                Daily
                            </option>
                            <option value="weekly" {{ old('section', request('section')) === 'weekly' ? 'selected' : '' }}>
                                Weekly
                            </option>
                            <option value="monthly" {{ old('section', request('section')) === 'monthly' ? 'selected' : '' }}>
                                Monthly
                            </option>
                        </select>
                        <div class="absolute inset-0 bg-gradient-to-r from-neon-blue to-neon-purple rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                        <i class="lucide-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-text-muted pointer-events-none"></i>
                    </div>
                    @error('section')
                        <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                            <i class="lucide-alert-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Time Schedule Fields (for Daily tasks) -->
                <div id="timeScheduleCard"
                    class="bg-bg-secondary/50 border border-border-color rounded-2xl p-6 {{ old('section', request('section')) === 'daily' ? '' : 'hidden' }}">
                    <h3 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                        <i class="lucide-clock text-neon-cyan"></i>
                        Time Schedule <span class="text-text-muted text-sm">(Optional for Daily Tasks)</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Start Time -->
                        <div>
                            <label for="start_time"
                                class="flex items-center gap-2 text-text-secondary text-sm font-medium mb-2">
                                <i class="lucide-sunrise text-neon-cyan"></i>
                                Start Time
                            </label>
                            <div class="relative">
                                <input id="start_time" type="time" name="start_time" value="{{ old('start_time') }}"
                                    class="w-full px-4 py-4 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary focus:outline-none focus:ring-2 focus:ring-neon-cyan/50 focus:border-neon-cyan transition-all duration-300">
                                <div class="absolute inset-0 bg-gradient-to-r from-neon-blue to-neon-purple rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                            </div>
                            @error('start_time')
                                <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                                    <i class="lucide-alert-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time"
                                class="flex items-center gap-2 text-text-secondary text-sm font-medium mb-2">
                                <i class="lucide-sunset text-neon-cyan"></i>
                                End Time
                            </label>
                            <div class="relative">
                                <input id="end_time" type="time" name="end_time" value="{{ old('end_time') }}"
                                    class="w-full px-4 py-4 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary focus:outline-none focus:ring-2 focus:ring-neon-cyan/50 focus:border-neon-cyan transition-all duration-300">
                                <div class="absolute inset-0 bg-gradient-to-r from-neon-blue to-neon-purple rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                            </div>
                            @error('end_time')
                                <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                                    <i class="lucide-alert-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-neon-cyan/10 border border-neon-cyan/30 rounded-xl">
                        <div class="flex items-start gap-3">
                            <i class="lucide-lightbulb text-neon-cyan mt-1"></i>
                            <div class="text-neon-cyan text-sm">
                                <strong>Tip:</strong> Set times to create a structured daily timetable. Tasks will be displayed in chronological order.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Goal Field -->
                <div>
                    <label for="goal_id" class="flex items-center gap-2 text-text-secondary text-sm font-medium mb-2">
                        <i class="lucide-flag text-neon-cyan"></i>
                        Associated Goal <span class="text-text-muted">(Optional)</span>
                    </label>
                    <div class="relative">
                        <select id="goal_id" name="goal_id"
                            class="w-full px-4 py-4 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary focus:outline-none focus:ring-2 focus:ring-neon-cyan/50 focus:border-neon-cyan transition-all duration-300 appearance-none cursor-pointer">
                            <option value="">No goal (standalone task)</option>
                            @foreach($goals as $goal)
                                <option value="{{ $goal->id }}" {{ old('goal_id', request('goal_id')) == $goal->id ? 'selected' : '' }}>
                                    {{ $goal->title }} ({{ ucfirst($goal->section) }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-0 bg-gradient-to-r from-neon-blue to-neon-purple rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                        <i class="lucide-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-text-muted pointer-events-none"></i>
                    </div>
                    @error('goal_id')
                        <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                            <i class="lucide-alert-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Due Date Field -->
                <div>
                    <label for="due_date" class="flex items-center gap-2 text-text-secondary text-sm font-medium mb-2">
                        <i class="lucide-calendar text-neon-cyan"></i>
                        Due Date <span class="text-text-muted">(Optional)</span>
                    </label>
                    <div class="relative">
                        <input id="due_date" type="date" name="due_date" value="{{ old('due_date') }}"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-4 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary focus:outline-none focus:ring-2 focus:ring-neon-cyan/50 focus:border-neon-cyan transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-neon-blue to-neon-purple rounded-xl opacity-0 blur-sm transition-opacity duration-300 -z-10"></div>
                    </div>
                    @error('due_date')
                        <div class="mt-2 flex items-center gap-2 text-neon-orange text-sm">
                            <i class="lucide-alert-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <a href="{{ route('dashboard') }}"
                        class="flex-1 px-6 py-4 bg-bg-secondary border border-border-color text-text-secondary rounded-xl hover:bg-bg-hover transition-colors duration-300 flex items-center justify-center gap-2">
                        <i class="lucide-arrow-left"></i>
                        Cancel
                    </a>
                    <button type="submit"
                        class="flex-1 px-6 py-4 bg-gradient-to-r from-neon-blue to-neon-purple text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-neon-blue/25 transition-all duration-300 flex items-center justify-center gap-3 group relative overflow-hidden">
                        <span class="relative z-10">Create Task</span>
                        <i class="lucide-check relative z-10"></i>
                        <div class="absolute inset-0 bg-gradient-to-r from-neon-blue to-neon-purple opacity-0 group-hover:opacity-100 blur-lg transition-opacity duration-300"></div>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips Card -->
        <div class="mt-6 bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-3xl p-6 shadow-2xl">
            <h3 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                <i class="lucide-lightbulb text-neon-yellow"></i>
                Tips for Effective Task Scheduling
            </h3>
            <ul class="space-y-3 text-text-secondary text-sm">
                <li class="flex items-start gap-3">
                    <i class="lucide-check-circle text-neon-green mt-0.5"></i>
                    <span>For daily tasks, set start and end times to create a structured timetable</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="lucide-check-circle text-neon-green mt-0.5"></i>
                    <span>Time-scheduled tasks will appear in chronological order on your dashboard</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="lucide-check-circle text-neon-green mt-0.5"></i>
                    <span>Current ongoing tasks will be highlighted automatically</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="lucide-check-circle text-neon-green mt-0.5"></i>
                    <span>Break down large tasks into smaller time blocks for better focus</span>
                </li>
            </ul>
        </div>
    </div>

    @push('scripts')
        <script>
            // Show/hide time schedule card based on section
            document.getElementById('section').addEventListener('change', function () {
                const timeScheduleCard = document.getElementById('timeScheduleCard');
                if (this.value === 'daily') {
                    timeScheduleCard.classList.remove('hidden');
                } else {
                    timeScheduleCard.classList.add('hidden');
                    // Clear time fields when not daily
                    document.getElementById('start_time').value = '';
                    document.getElementById('end_time').value = '';
                }
            });

            // Add focus glow effects
            document.querySelectorAll('input, select, textarea').forEach(element => {
                element.addEventListener('focus', function () {
                    const glow = this.parentElement.querySelector('.absolute.inset-0');
                    if (glow) glow.style.opacity = '0.3';
                });
                element.addEventListener('blur', function () {
                    const glow = this.parentElement.querySelector('.absolute.inset-0');
                    if (glow) glow.style.opacity = '0';
                });
            });
        </script>
    @endpush