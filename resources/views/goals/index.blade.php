@extends('layouts.app')

@section('title', 'Goals - DailyDrive')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 pt-24">
        <div class="flex flex-col lg:flex-row gap-4 mb-6">
            <div class="flex-1">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                    <h1 class="text-4xl lg:text-5xl font-display font-bold">
                        <i class="lucide-target text-neon-green"></i> Goals
                    </h1>
                    <a href="{{ route('goals.create') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                        <i class="lucide-plus-circle"></i> Create New Goal
                    </a>
                </div>
                <p class="text-text-secondary mt-4 lg:mt-2">Track your progress towards achieving your goals</p>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('goals.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 {{ !$section ? 'bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary' : 'bg-transparent border-2 border-neon-green text-neon-green' }} rounded-lg font-medium hover:transform hover:translate-y-[-2px] transition-all duration-300">
                <i class="lucide-layers"></i> All
            </a>
            <a href="{{ route('goals.index', ['section' => 'daily']) }}"
                class="inline-flex items-center gap-2 px-4 py-2 {{ $section === 'daily' ? 'bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary' : 'bg-transparent border-2 border-neon-green text-neon-green' }} rounded-lg font-medium hover:transform hover:translate-y-[-2px] transition-all duration-300">
                <i class="lucide-sun"></i> Daily
            </a>
            <a href="{{ route('goals.index', ['section' => 'weekly']) }}"
                class="inline-flex items-center gap-2 px-4 py-2 {{ $section === 'weekly' ? 'bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary' : 'bg-transparent border-2 border-neon-green text-neon-green' }} rounded-lg font-medium hover:transform hover:translate-y-[-2px] transition-all duration-300">
                <i class="lucide-calendar"></i> Weekly
            </a>
            <a href="{{ route('goals.index', ['section' => 'monthly']) }}"
                class="inline-flex items-center gap-2 px-4 py-2 {{ $section === 'monthly' ? 'bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary' : 'bg-transparent border-2 border-neon-green text-neon-green' }} rounded-lg font-medium hover:transform hover:translate-y-[-2px] transition-all duration-300">
                <i class="lucide-calendar-days"></i> Monthly
            </a>
        </div>

        @if($goals->isEmpty())
            <div class="text-center py-16">
                <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-8 shadow-lg">
                    <i class="lucide-target text-6xl text-text-muted mb-4"></i>
                    <h3 class="text-2xl font-semibold text-text-primary mb-2">No goals yet!</h3>
                    <p class="text-text-secondary mb-4">Set your first goal and start making progress.</p>
                    <a href="{{ route('goals.create') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300 mt-4">
                        <i class="lucide-plus-circle"></i> Create Your First Goal
                    </a>
                </div>
            </div>
        @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($goals as $goal)
                                <div
                                    class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg hover:transform hover:scale-105 transition-all duration-300 h-full goal-card">
                                    <div class="flex justify-between items-start mb-4">
                                        <h5 class="font-semibold text-text-primary mb-0">{{ $goal->title }}</h5>
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $goal->section === 'daily' ? 'bg-neon-blue/20 text-neon-blue' : ($goal->section === 'weekly' ? 'bg-neon-yellow/20 text-neon-yellow' : 'bg-neon-green/20 text-neon-green') }}">
                                            {{ ucfirst($goal->section) }}
                                        </span>
                                    </div>
                                    @if($goal->description)
                                        <p class="text-text-secondary mb-4">{{ $goal->description }}</p>
                                    @endif

                                    <!-- Progress Bar -->
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-text-secondary text-sm">Progress</span>
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-neon-green/20 text-neon-green">
                                                {{ number_format($goal->progress, 0) }}%
                                            </span>
                                        </div>
                                        <div class="w-full bg-bg-secondary rounded-full h-5 overflow-hidden">
                                            <div class="bg-gradient-to-r from-neon-green to-neon-blue h-full rounded-full transition-all duration-500"
                                                role="progressbar" style="width: {{ $goal->progress }}%">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Task Count -->
                                    <div class="flex justify-between text-text-secondary text-sm mb-4">
                                        <span class="flex items-center gap-1">
                                            <i class="lucide-list-checks"></i>
                                            {{ $goal->tasks->count() }} Total Tasks
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="lucide-check-circle"></i>
                                            {{ $goal->tasks->where('status', 'completed')->count() }} Completed
                                        </span>
                                    </div>

                                    <!-- Recent Tasks -->
                                    @if($goal->tasks->take(3)->count() > 0)
                                        <div class="mb-4">
                                            <p class="text-sm text-text-secondary mb-2"><strong>Recent Tasks:</strong></p>
                                            <ul class="space-y-1 mb-0">
                                                @foreach($goal->tasks->take(3) as $task)
                                                    <li class="text-sm {{ $task->isCompleted() ? 'line-through text-text-muted' : '' }}">
                                                        <i
                                                            class="lucide-{{ $task->isCompleted() ? 'check-circle text-neon-green' : 'circle' }} text-xs mr-1"></i>
                                                        {{ Str::limit($task->title, 40) }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center pt-4 border-t border-border-color">
                                    <a href="{{ route('goals.show', $goal) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1 text-sm border border-neon-cyan text-neon-cyan rounded hover:bg-neon-cyan/10 transition-colors duration-200">
                                        <i class="lucide-eye"></i> View
                                    </a>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('goals.edit', $goal) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1 text-sm border border-neon-green text-neon-green rounded hover:bg-neon-green/10 transition-colors duration-200">
                                            <i class="lucide-edit-2"></i> Edit
                                        </a>
                                        <form action="{{ route('goals.destroy', $goal) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure? This will also remove the goal association from all tasks.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1 text-sm border border-neon-orange text-neon-orange rounded hover:bg-neon-orange/10 transition-colors duration-200">
                                                <i class="lucide-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        @endif
    </div>
@endsection