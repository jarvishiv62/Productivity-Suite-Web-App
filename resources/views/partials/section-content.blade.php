<div class="row">
    <!-- Tasks Column -->
    <div class="col-lg-8">
        <!-- Goals Section -->
        @if($goals->isNotEmpty())
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="lucide-target" style="color: var(--neon-cyan);"></i>
                        <span
                            style="background: var(--accent-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ ucfirst($section) }}
                            Goals</span>
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($goals as $goal)
                        <div class="goal-item mb-3"
                            style="padding: var(--space-md); border-radius: var(--radius-md); background: var(--bg-secondary);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">
                                    <a href="{{ route('goals.show', $goal) }}"
                                        style="color: var(--text-accent); text-decoration: none; font-weight: 600;">
                                        {{ $goal->title }}
                                    </a>
                                </h6>
                                <span class="badge bg-{{ $goal->getProgressColor() }}"
                                    style="background: var(--secondary-gradient); color: var(--bg-primary);">
                                    {{ number_format($goal->progress, 0) }}%
                                </span>
                            </div>
                            <div class="progress" style="height: 10px; background: var(--bg-tertiary);">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $goal->progress }}%; background: var(--secondary-gradient);">
                                </div>
                            </div>
                            @if($goal->description)
                                <p class="text-muted small mt-2 mb-0">{{ Str::limit($goal->description, 100) }}</p>
                            @endif
                        </div>
                    @endforeach
                    <a href="{{ route('goals.create') }}?section={{ $section }}" class="btn btn-outline btn-sm">
                        <i class="lucide-plus"></i> Add New Goal
                    </a>
                </div>
            </div>
        @endif

        <!-- Pending Tasks -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        @if($section === 'daily')
                            <i class="lucide-sun" style="color: var(--neon-yellow);"></i>
                            <span style="color: var(--neon-yellow);">Today's Schedule</span>
                        @else
                            <i class="lucide-clock" style="color: var(--neon-blue);"></i>
                            <span style="color: var(--neon-blue);">Pending Tasks</span>
                        @endif
                        <span class="badge bg-warning"
                            style="background: var(--accent-gradient); color: white;">{{ $tasks->where('status', 'pending')->count() }}</span>
                    </h5>
                    <a href="{{ route('tasks.create') }}?section={{ $section }}" class="btn btn-primary btn-sm">
                        <i class="lucide-plus"></i> Add Task
                    </a>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($tasks->where('status', 'pending') as $task)
                    <li class="list-group-item task-item" data-task-id="{{ $task->id }}" @if($task->start_time)
                    data-start-time="{{ $task->start_time->format('H:i:s') }}" @endif @if($task->end_time)
                        data-end-time="{{ $task->end_time->format('H:i:s') }}" @endif
                        style="position: relative; transition: var(--transition-normal);">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start">
                                    <div class="form-check">
                                        <input class="form-check-input task-checkbox" type="checkbox"
                                            id="task-{{ $task->id }}" data-task-id="{{ $task->id }}"
                                            style="accent-color: var(--neon-cyan);">
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label" for="task-{{ $task->id }}" style="cursor: pointer;">
                                            <h6 class="mb-1" style="color: var(--text-primary); font-weight: 600;">
                                                {{ $task->title }}
                                                <span class="task-status-badge"></span>
                                            </h6>
                                        </label>

                                        <!-- Time Badge for Daily Tasks -->
                                        @if($section === 'daily' && $task->time_range)
                                            <div class="mb-2">
                                                <span class="badge bg-primary"
                                                    style="background: var(--primary-gradient); color: white;">
                                                    <i class="lucide-clock"></i> {{ $task->time_range }}
                                                </span>
                                                @if($task->duration)
                                                    <span class="badge bg-secondary">
                                                        {{ $task->duration }} min
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        @if($task->goal)
                                            <span class="badge bg-info" style="background: var(--neon-blue); color: white;">
                                                <i class="lucide-target"></i> {{ $task->goal->title }}
                                            </span>
                                        @endif
                                        @if($task->description)
                                            <p class="text-muted small mb-1">{{ $task->description }}</p>
                                        @endif
                                        @if($task->due_date && $section !== 'daily')
                                            <small>
                                                <i class="lucide-calendar"></i>
                                                <span class="{{ $task->isOverdue() ? 'text-danger fw-bold' : 'text-muted' }}">
                                                    {{ $task->due_date->format('M j, Y') }}
                                                    @if($task->isOverdue())
                                                        (Overdue)
                                                    @endif
                                                </span>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; gap: var(--space-xs);">
                                <a href="{{ route('tasks.edit', $task) }}" class="action-btn edit-btn"
                                    style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: var(--radius-md); background: var(--bg-tertiary); border: 1px solid var(--neon-green); color: var(--neon-green); text-decoration: none; transition: var(--transition-normal);"
                                    title="Edit Task">
                                    ✏️
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn"
                                        style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: var(--radius-md); background: var(--bg-tertiary); border: 1px solid var(--neon-orange); color: var(--neon-orange); cursor: pointer; transition: var(--transition-normal);"
                                        title="Delete Task">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-center py-4" style="background: var(--bg-secondary);">
                        <i class="lucide-check-circle display-4" style="color: var(--neon-cyan);"></i>
                        <p class="mt-2 mb-0" style="color: var(--text-secondary);">No pending tasks! Time to create new ones
                            or celebrate.</p>
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Completed Tasks -->
        @if($tasks->where('status', 'completed')->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="lucide-check-circle" style="color: var(--neon-cyan);"></i>
                        <span style="color: var(--neon-cyan);">Completed Tasks</span>
                        <span class="badge bg-success"
                            style="background: var(--secondary-gradient); color: var(--bg-primary);">{{ $tasks->where('status', 'completed')->count() }}</span>
                    </h5>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($tasks->where('status', 'completed') as $task)
                        <li class="list-group-item" style="opacity: 0.7;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-start">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" checked disabled>
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-check-label"
                                                style="text-decoration: line-through; color: var(--text-muted);">
                                                <h6 class="mb-1">{{ $task->title }}</h6>
                                            </label>
                                            @if($section === 'daily' && $task->time_range)
                                                <span class="badge bg-secondary">
                                                    <i class="lucide-clock"></i> {{ $task->time_range }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn"
                                        style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: var(--radius-md); background: var(--bg-tertiary); border: 1px solid var(--neon-orange); color: var(--neon-orange); cursor: pointer; transition: var(--transition-normal);"
                                        title="Delete Task">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Current Time (for daily section) -->
        @if($section === 'daily')
            <div class="card mb-3 time-display">
                <div class="card-body text-center">
                    <h6 class="card-title mb-2">
                        <i class="lucide-clock"></i> Current Time
                    </h6>
                    <h3 class="mb-0" id="currentTime">{{ now()->format('g:i A') }}</h3>
                    <p class="small mb-0 mt-1" id="currentDate">{{ now()->format('l, F j') }}</p>
                </div>
            </div>
        @endif

        <!-- Progress Summary -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="lucide-trending-up" style="color: var(--neon-cyan);"></i>
                    <span style="color: var(--neon-cyan);">Progress Summary</span>
                </h5>
                <div class="progress mb-2" style="height: 25px; background: var(--bg-tertiary);">
                    @php
                        $totalTasks = $tasks->count();
                        $completedTasks = $tasks->where('status', 'completed')->count();
                        $percentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                    @endphp
                    <div class="progress-bar" role="progressbar"
                        style="width: {{ $percentage }}%; background: var(--secondary-gradient); color: var(--bg-primary); font-weight: 600;">
                        {{ $percentage }}%
                    </div>
                </div>
                <p class="text-muted small mb-0">
                    {{ $completedTasks }} of {{ $totalTasks }} tasks completed
                </p>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="lucide-bar-chart-2" style="color: var(--neon-blue);"></i>
                    <span style="color: var(--neon-blue);">Quick Stats</span>
                </h5>
                <ul class="list-unstyled mb-0">
                    @if($section === 'daily')
                        <li class="mb-2">
                            <i class="lucide-play-circle" style="color: var(--neon-cyan);"></i>
                            <strong>Ongoing:</strong> {{ $tasks->filter(fn($t) => $t->isOngoing())->count() }}
                        </li>
                        <li class="mb-2">
                            <i class="lucide-clock" style="color: var(--neon-blue);"></i>
                            <strong>Upcoming:</strong> {{ $tasks->filter(fn($t) => $t->isUpcoming())->count() }}
                        </li>
                    @endif
                    <li class="mb-2">
                        <i class="lucide-hourglass" style="color: var(--neon-yellow);"></i>
                        <strong>Pending:</strong> {{ $tasks->where('status', 'pending')->count() }}
                    </li>
                    <li class="mb-2">
                        <i class="lucide-check-circle" style="color: var(--neon-cyan);"></i>
                        <strong>Completed:</strong> {{ $tasks->where('status', 'completed')->count() }}
                    </li>
                    @if($section !== 'daily')
                        <li class="mb-2">
                            <i class="lucide-alert-triangle" style="color: var(--neon-orange);"></i>
                            <strong>Overdue:</strong> {{ $tasks->filter(fn($t) => $t->isOverdue())->count() }}
                        </li>
                    @endif
                    <li>
                        <i class="lucide-target" style="color: var(--neon-purple);"></i>
                        <strong>Goals:</strong> {{ $goals->count() }}
                    </li>
                </ul>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="lucide-zap" style="color: var(--neon-yellow);"></i>
                    <span style="color: var(--neon-yellow);">Quick Actions</span>
                </h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('tasks.create') }}?section={{ $section }}" class="btn btn-outline">
                        <i class="lucide-plus"></i> Add {{ ucfirst($section) }} Task
                    </a>
                    <a href="{{ route('goals.create') }}?section={{ $section }}" class="btn btn-secondary">
                        <i class="lucide-target"></i> Create {{ ucfirst($section) }} Goal
                    </a>
                    <a href="{{ route('goals.index') }}?section={{ $section }}" class="btn btn-outline"
                        style="border-color: var(--neon-green); color: var(--neon-green);">
                        👁️ View All Goals
                    </a>
                </div>
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
                        class: 'task-ongoing',
                        html: `
                                                    <span class="badge bg-success pulse-animation">
                                                        <i class="bi bi-play-fill"></i> In Progress
                                                    </span>`
                    },
                    upcoming: {
                        class: 'task-upcoming',
                        html: `
                                                    <span class="badge bg-info">
                                                        <i class="bi bi-clock"></i> Upcoming
                                                    </span>`
                    },
                    past: {
                        class: 'task-past',
                        html: `
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-exclamation-triangle"></i> Missed
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
                        .replace(/\b(task-ongoing|task-upcoming|task-past)\b/g, '')
                        .trim();
                    taskItem.classList.add(statusConfig[status].class);
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