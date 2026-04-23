@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 pt-24">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-text-primary mb-2 flex items-center gap-3">
                    <i class="lucide-list-checks text-neon-cyan"></i>
                    My Tasks
                </h1>
                <p class="text-text-secondary">{{ now()->format('l, F j, Y') }}</p>
            </div>

            <!-- Category Toggles -->
            <div class="flex flex-col sm:flex-row gap-2">
                <!-- Filter Buttons -->
                <div class="flex gap-2">
                    <button onclick="filterTasks('all')"
                        class="category-btn flex items-center gap-2 px-4 py-2 bg-bg-secondary border border-border-color rounded-lg text-text-secondary font-medium hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 active:bg-bg-hover active:text-neon-cyan active:border-neon-cyan"
                        data-category="all">
                        <i class="lucide-layers"></i>
                        All Tasks
                    </button>
                    <button onclick="filterTasks('daily')"
                        class="category-btn flex items-center gap-2 px-4 py-2 bg-bg-secondary border border-border-color rounded-lg text-text-secondary font-medium hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 active:bg-bg-hover active:text-neon-cyan active:border-neon-cyan"
                        data-category="daily">
                        <i class="lucide-sun"></i>
                        Daily
                    </button>
                    <button onclick="filterTasks('weekly')"
                        class="category-btn flex items-center gap-2 px-4 py-2 bg-bg-secondary border border-border-color rounded-lg text-text-secondary font-medium hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 active:bg-bg-hover active:text-neon-cyan active:border-neon-cyan"
                        data-category="weekly">
                        <i class="lucide-calendar"></i>
                        Weekly
                    </button>
                    <button onclick="filterTasks('monthly')"
                        class="category-btn flex items-center gap-2 px-4 py-2 bg-bg-secondary border border-border-color rounded-lg text-text-secondary font-medium hover:bg-bg-hover hover:text-neon-cyan transition-all duration-300 active:bg-bg-hover active:text-neon-cyan active:border-neon-cyan"
                        data-category="monthly">
                        <i class="lucide-calendar-days"></i>
                        Monthly
                    </button>
                </div>

                <!-- Add Task Button -->
                <a href="{{ route('tasks.create') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-neon-blue to-neon-purple text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-neon-blue/25 transition-all duration-300 group relative overflow-hidden">
                    <i class="lucide-plus relative z-10"></i>
                    <span class="relative z-10">Add New Task</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-neon-blue to-neon-purple opacity-0 group-hover:opacity-100 blur-lg transition-opacity duration-300">
                    </div>
                </a>
            </div>
        </div>

        @if($tasks->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-bg-secondary/50 border border-border-color rounded-3xl mb-6">
                    <i class="lucide-inbox text-text-muted text-4xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-text-primary mb-4">No tasks yet!</h3>
                <p class="text-text-secondary mb-8 max-w-md mx-auto">Start your productive day by adding your first task. Stay organized and crush your goals!</p>
                <a href="{{ route('tasks.create') }}"
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-2xl hover:shadow-neon-green/25 transition-all duration-300">
                    <i class="lucide-plus-circle mr-2"></i>
                    Create Your First Task
                </a>
            </div>
        @else
            <!-- Tasks Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tasks as $task)
                    <div class="task-card bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg hover:transform hover:scale-105 transition-all duration-300 relative overflow-hidden group"
                        data-section="{{ $task->section }}">
                        <!-- Task Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-text-primary mb-2 pr-2">{{ $task->title }}</h3>
                                @if($task->description)
                                    <p class="text-text-secondary text-sm line-clamp-2">{{ $task->description }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Status Badge -->
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $task->status === 'completed' ? 'bg-neon-green/20 text-neon-green border border-neon-green/30' : 'bg-neon-yellow/20 text-neon-yellow border border-neon-yellow/30' }}">
                                    {{ ucfirst($task->status) }}
                                </span>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('tasks.edit', $task) }}"
                                        class="p-2 text-neon-cyan hover:text-neon-blue transition-colors">
                                        <i class="lucide-edit-2"></i>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this task?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-neon-orange hover:text-red-400 transition-colors">
                                            <i class="lucide-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Task Meta -->
                        <div class="space-y-3 text-sm text-text-secondary">
                            <!-- Section -->
                            <div class="flex items-center gap-2">
                                <i class="lucide-calendar text-neon-cyan"></i>
                                <span>{{ ucfirst($task->section) }}</span>
                            </div>

                            <!-- Time Schedule (if daily) -->
                            @if($task->section === 'daily' && ($task->start_time || $task->end_time))
                                <div class="flex items-center gap-2">
                                    <i class="lucide-clock text-neon-cyan"></i>
                                    <span>
                                        @if($task->start_time) {{ $task->start_time }}@endif
                                        @if($task->start_time && $task->end_time) - @endif
                                        @if($task->end_time) {{ $task->end_time }}@endif
                                    </span>
                                </div>
                            @endif

                            <!-- Due Date -->
                            @if($task->due_date)
                                <div class="flex items-center gap-2">
                                    <i class="lucide-calendar-x text-neon-cyan"></i>
                                    <span>Due: {{ $task->due_date->format('M j, Y') }}</span>
                                </div>
                            @endif

                            <!-- Goal -->
                            @if($task->goal)
                                <div class="flex items-center gap-2">
                                    <i class="lucide-flag text-neon-cyan"></i>
                                    <a href="{{ route('goals.show', $task->goal) }}"
                                        class="text-neon-cyan hover:text-neon-blue transition-colors hover:underline">
                                        {{ $task->goal->title }}
                                    </a>
                                </div>
                            @endif

                            <!-- Created Date -->
                            <div class="flex items-center gap-2">
                                <i class="lucide-plus-circle text-neon-cyan"></i>
                                <span>Created: {{ $task->created_at->format('M j, Y') }}</span>
                            </div>
                        </div>

                        <!-- Hover Effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-neon-blue/10 to-neon-purple/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($tasks, 'links'))
                <div class="flex justify-center mt-8">
                    {{ $tasks->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

@push('scripts')
    <script>
        // Filter tasks by category
        function filterTasks(category) {
            // Update active button
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Set active button
            const activeBtn = document.querySelector(`[data-category="${category}"]`);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }

            // Filter task cards
            const taskCards = document.querySelectorAll('.task-card');
            taskCards.forEach(card => {
                const cardSection = card.dataset.section;
                if (category === 'all' || cardSection === category) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        // Initialize with 'all' filter
        document.addEventListener('DOMContentLoaded', function () {
            filterTasks('all');
        });
    </script>
@endpush