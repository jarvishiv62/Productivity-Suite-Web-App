<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Tasks Column -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Goals Section -->
        @if($goals->isNotEmpty())
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-neon-cyan to-neon-blue text-white p-4">
                    <h5 class="text-lg font-semibold flex items-center gap-2">
                        <i class="lucide-target"></i>
                        <span>{{ ucfirst($section) }} Goals</span>
                    </h5>
                </div>
                <div class="p-4 space-y-4">
                    @foreach($goals as $goal)
                        <div class="bg-bg-secondary/50 rounded-xl p-4 border border-border-color/50">
                            <div class="flex justify-between items-center mb-3">
                                <h6 class="mb-0">
                                    <a href="{{ route('goals.show', $goal) }}"
                                        class="text-neon-cyan hover:text-neon-blue transition-colors duration-200 font-semibold">
                                        {{ $goal->title }}
                                    </a>
                                </h6>
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-neon-green to-neon-blue text-white">
                                    {{ number_format($goal->progress, 0) }}%
                                </span>
                            </div>
                            <div class="w-full bg-bg-tertiary rounded-full h-2 mb-3">
                                <div class="bg-gradient-to-r from-neon-green to-neon-blue h-full rounded-full transition-all duration-500"
                                    role="progressbar" data-goal-id="{{ $goal->id }}" style="width: {{ $goal->progress }}%">
                                </div>
                            </div>
                            @if($goal->description)
                                <p class="text-text-secondary text-sm">{{ Str::limit($goal->description, 100) }}</p>
                            @endif
                        </div>
                    @endforeach
                    <a href="{{ route('goals.create') }}?section={{ $section }}"
                        class="inline-flex items-center gap-2 px-4 py-2 border border-neon-cyan text-neon-cyan rounded-lg hover:bg-neon-cyan/10 transition-colors duration-200">
                        <i class="lucide-plus"></i> Add New Goal
                    </a>
                </div>
            </div>
        @endif

        <!-- Pending Tasks -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-neon-yellow to-neon-orange text-white p-4">
                <div class="flex justify-between items-center">
                    <h5 class="text-lg font-semibold flex items-center gap-2">
                        @if($section === 'daily')
                            <i class="lucide-sun"></i>
                            <span>Today's Schedule</span>
                        @else
                            <i class="lucide-clock"></i>
                            <span>Pending Tasks</span>
                        @endif
                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-white/20">
                            {{ $tasks->where('status', 'pending')->count() }}
                        </span>
                    </h5>
                    <a href="{{ route('tasks.create') }}?section={{ $section }}"
                        class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="lucide-plus"></i> Add Task
                    </a>
                </div>
            </div>
            <div class="divide-y divide-border-color">
                @forelse($tasks->where('status', 'pending') as $task)
                    <div class="p-4 task-item hover:bg-bg-secondary/30 transition-colors duration-200"
                        data-task-id="{{ $task->id }}" @if($task->goal) data-goal-id="{{ $task->goal->id }}" @endif
                        @if($task->start_time) data-start-time="{{ $task->start_time->format('H:i:s') }}" @endif
                        @if($task->end_time) data-end-time="{{ $task->end_time->format('H:i:s') }}" @endif>
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    <div class="pt-1">
                                        <input
                                            class="task-checkbox w-5 h-5 text-neon-cyan bg-bg-secondary border-border-color rounded focus:ring-neon-cyan/50 cursor-pointer"
                                            type="checkbox" id="task-{{ $task->id }}" data-task-id="{{ $task->id }}">
                                    </div>
                                    <div class="flex-1">
                                        <label for="task-{{ $task->id }}" class="cursor-pointer">
                                            <h6 class="text-text-primary font-semibold mb-1">
                                                {{ $task->title }}
                                                <span class="task-status-badge"></span>
                                            </h6>
                                        </label>

                                        <!-- Time Badge for Daily Tasks -->
                                        @if($section === 'daily' && $task->time_range)
                                            <div class="mb-2">
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-neon-pink to-neon-purple text-white">
                                                    <i class="lucide-clock text-xs"></i> {{ $task->time_range }}
                                                </span>
                                                @if($task->duration)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-neon-blue/20 text-neon-blue ml-2">
                                                        {{ $task->duration }} min
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        @if($task->goal)
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-neon-blue/20 text-neon-blue">
                                                <i class="lucide-target text-xs"></i> {{ $task->goal->title }}
                                            </span>
                                        @endif
                                        @if($task->description)
                                            <p class="text-text-secondary text-sm mb-1">{{ $task->description }}</p>
                                        @endif
                                        @if($task->due_date && $section !== 'daily')
                                            <div class="text-sm">
                                                <i class="lucide-calendar text-text-muted"></i>
                                                <span
                                                    class="{{ $task->isOverdue() ? 'text-neon-orange font-semibold' : 'text-text-muted' }}">
                                                    {{ $task->due_date->format('M j, Y') }}
                                                    @if($task->isOverdue())
                                                        (Overdue)
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('tasks.edit', $task) }}"
                                    class="action-btn edit-btn p-2 text-neon-green hover:bg-neon-green/10 rounded-lg transition-colors duration-200"
                                    title="Edit Task">
                                    <i class="lucide-edit-2"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="action-btn delete-btn p-2 text-neon-orange hover:bg-neon-orange/10 rounded-lg transition-colors duration-200"
                                        title="Delete Task">
                                        <i class="lucide-trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center bg-bg-secondary/30">
                        <i class="lucide-check-circle text-4xl text-neon-cyan mb-3"></i>
                        <p class="text-text-secondary">No pending tasks! Time to create new ones or celebrate.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Completed Tasks -->
        @if($tasks->where('status', 'completed')->count() > 0)
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-neon-green to-neon-blue text-white p-4">
                    <h5 class="text-lg font-semibold flex items-center gap-2">
                        <i class="lucide-check-circle"></i>
                        <span>Completed Tasks</span>
                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-white/20">
                            {{ $tasks->where('status', 'completed')->count() }}
                        </span>
                    </h5>
                </div>
                <div class="divide-y divide-border-color opacity-70">
                    @foreach($tasks->where('status', 'completed') as $task)
                        <div class="p-4">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-start gap-3">
                                        <div class="pt-1">
                                            <input class="w-5 h-5 text-neon-green bg-bg-secondary border-border-color rounded"
                                                type="checkbox" checked disabled>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="text-text-muted line-through mb-1">{{ $task->title }}</h6>
                                            @if($section === 'daily' && $task->time_range)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-neon-blue/20 text-neon-blue">
                                                    <i class="lucide-clock text-xs"></i> {{ $task->time_range }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="action-btn delete-btn p-2 text-neon-orange hover:bg-neon-orange/10 rounded-lg transition-colors duration-200"
                                        title="Delete Task">
                                        <i class="lucide-trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Current Time (for daily section) -->
        @if($section === 'daily')
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg p-6 text-center">
                <h6 class="text-lg font-semibold text-text-primary mb-3 flex items-center justify-center gap-2">
                    <i class="lucide-clock text-neon-cyan"></i> Current Time
                </h6>
                <h3 class="text-2xl font-bold text-neon-cyan mb-1" id="currentTime">{{ now()->format('g:i A') }}</h3>
                <p class="text-text-secondary text-sm" id="currentDate">{{ now()->format('l, F j') }}</p>
            </div>
        @endif

        <!-- Progress Summary -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg p-6">
            <h5 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                <i class="lucide-trending-up text-neon-cyan"></i> Progress Summary
            </h5>
            @php
                $totalTasks = $tasks->count();
                $completedTasks = $tasks->where('status', 'completed')->count();
                $percentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            @endphp
            <div class="w-full bg-bg-tertiary rounded-full h-6 mb-3">
                <div class="bg-gradient-to-r from-neon-green to-neon-blue h-full rounded-full transition-all duration-500 flex items-center justify-center text-xs font-semibold text-white"
                    role="progressbar" data-goal-id="sidebar-progress" style="width: {{ $percentage }}%">
                    {{ $percentage }}%
                </div>
            </div>
            <p class="text-text-secondary text-sm">
                {{ $completedTasks }} of {{ $totalTasks }} tasks completed
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg p-6">
            <h5 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                <i class="lucide-bar-chart-2 text-neon-blue"></i> Quick Stats
            </h5>
            <div class="space-y-3">
                @if($section === 'daily')
                    <div class="flex justify-between items-center">
                        <span class="text-text-secondary text-sm flex items-center gap-2">
                            <i class="lucide-play-circle text-neon-cyan"></i> Ongoing
                        </span>
                        <span
                            class="text-neon-cyan font-semibold">{{ $tasks->filter(fn($t) => $t->isOngoing())->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-text-secondary text-sm flex items-center gap-2">
                            <i class="lucide-clock text-neon-blue"></i> Upcoming
                        </span>
                        <span
                            class="text-neon-blue font-semibold">{{ $tasks->filter(fn($t) => $t->isUpcoming())->count() }}</span>
                    </div>
                @endif
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary text-sm flex items-center gap-2">
                        <i class="lucide-hourglass text-neon-yellow"></i> Pending
                    </span>
                    <span
                        class="text-neon-yellow font-semibold">{{ $tasks->where('status', 'pending')->count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary text-sm flex items-center gap-2">
                        <i class="lucide-check-circle text-neon-cyan"></i> Completed
                    </span>
                    <span
                        class="text-neon-cyan font-semibold">{{ $tasks->where('status', 'completed')->count() }}</span>
                </div>
                @if($section !== 'daily')
                    <div class="flex justify-between items-center">
                        <span class="text-text-secondary text-sm flex items-center gap-2">
                            <i class="lucide-alert-triangle text-neon-orange"></i> Overdue
                        </span>
                        <span
                            class="text-neon-orange font-semibold">{{ $tasks->filter(fn($t) => $t->isOverdue())->count() }}</span>
                    </div>
                @endif
                <div class="flex justify-between items-center">
                    <span class="text-text-secondary text-sm flex items-center gap-2">
                        <i class="lucide-target text-neon-purple"></i> Goals
                    </span>
                    <span class="text-neon-purple font-semibold">{{ $goals->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg p-6">
            <h5 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                <i class="lucide-zap text-neon-yellow"></i> Quick Actions
            </h5>
            <div class="space-y-3">
                <a href="{{ route('tasks.create') }}?section={{ $section }}"
                    class="block w-full text-center px-4 py-2 border border-neon-cyan text-neon-cyan rounded-lg hover:bg-neon-cyan/10 transition-colors duration-200">
                    <i class="lucide-plus"></i> Add {{ ucfirst($section) }} Task
                </a>
                <a href="{{ route('goals.create') }}?section={{ $section }}"
                    class="block w-full text-center px-4 py-2 bg-bg-secondary border border-border-color text-text-secondary rounded-lg hover:bg-bg-hover transition-colors duration-300">
                    <i class="lucide-target"></i> Create {{ ucfirst($section) }} Goal
                </a>
                <a href="{{ route('goals.index') }}?section={{ $section }}"
                    class="block w-full text-center px-4 py-2 border border-neon-green text-neon-green rounded-lg hover:bg-neon-green/10 transition-colors duration-200">
                    <i class="lucide-eye"></i> View All Goals
                </a>
            </div>
        </div>
    </div>
</div>

@if($section === 'daily')
    @push('scripts')
        <script>
            function updateSidebarTime() {
                const now = new Date();
                const timeEl = document.getElementById('currentTime');
                const dateEl = document.getElementById('currentDate');

                // Format and update time (h:mm AM/PM)
                if (timeEl) {
                    timeEl.textContent = now.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                }

                // Update date if needed
                if (dateEl) {
                    dateEl.textContent = now.toLocaleDateString('en-US', {
                        weekday: 'long',
                        month: 'long',
                        day: 'numeric'
                    });
                }

                updateTaskStatuses(now);
            }

            function updateTaskStatuses(now) {
                const currentTime = now.getHours() * 3600 + now.getMinutes() * 60 + now.getSeconds();
                const statusConfig = {
                    ongoing: {
                        class: 'task-ongoing bg-neon-green/10 border-l-4 border-neon-green',
                        html: `<span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-neon-green text-white animate-pulse">
                                            <i class="lucide-play text-xs"></i> In Progress
                                        </span>`
                    },
                    upcoming: {
                        class: 'task-upcoming bg-neon-blue/10 border-l-4 border-neon-blue',
                        html: `<span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-neon-blue text-white">
                                            <i class="lucide-clock text-xs"></i> Upcoming
                                        </span>`
                    },
                    past: {
                        class: 'task-past bg-neon-orange/10 border-l-4 border-neon-orange',
                        html: `<span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-neon-orange text-white">
                                            <i class="lucide-alert-triangle text-xs"></i> Missed
                                        </span>`
                    }
                };

                document.querySelectorAll('.task-item').forEach(taskItem => {
                    const startTime = taskItem.dataset.startTime;
                    const endTime = taskItem.dataset.endTime;
                    const statusBadge = taskItem.querySelector('.task-status-badge');

                    if (!startTime || !endTime) {
                        statusBadge.innerHTML = '';
                        return;
                    }

                    const [startH, startM] = startTime.split(':').map(Number);
                    const [endH, endM] = endTime.split(':').map(Number);
                    const startSeconds = startH * 3600 + startM * 60;
                    const endSeconds = endH * 3600 + endM * 60;

                    // Determine status
                    let status;
                    if (currentTime >= startSeconds && currentTime <= endSeconds) {
                        status = 'ongoing';
                    } else if (currentTime < startSeconds) {
                        status = 'upcoming';
                    } else {
                        status = 'past';
                    }

                    // Update UI
                    taskItem.className = taskItem.className
                        .replace(/\b(task-ongoing|task-upcoming|task-past|bg-\w+\/\d+|border-l-\d+|border-\w+)\b/g, '')
                        .trim() + ' p-4 task-item hover:bg-bg-secondary/30 transition-colors duration-200 ' + statusConfig[status].class;
                    statusBadge.innerHTML = statusConfig[status].html;
                });
            }

            // Update time immediately and then every minute
            document.addEventListener('DOMContentLoaded', function () {
                updateSidebarTime();
                setInterval(updateSidebarTime, 60000);
            });
        </script>
    @endpush
@endif