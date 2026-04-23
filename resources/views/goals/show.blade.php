@extends('layouts.app')

@section('title', $goal->title . ' - Goal Details')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 pt-24">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-8">
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-4">
                    <h1 class="text-3xl lg:text-4xl font-display font-bold text-text-primary">
                        <i class="lucide-target text-neon-green"></i> {{ $goal->title }}
                    </h1>
                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full {{ $goal->section === 'daily' ? 'bg-neon-blue/20 text-neon-blue' : ($goal->section === 'weekly' ? 'bg-neon-yellow/20 text-neon-yellow' : 'bg-neon-green/20 text-neon-green') }}">
                        {{ ucfirst($goal->section) }} Goal
                    </span>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('goals.edit', $goal) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-neon-green to-neon-blue text-white font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                    <i class="lucide-edit-2"></i> Edit Goal
                </a>
                <a href="{{ route('goals.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-bg-secondary border border-border-color text-text-secondary rounded-lg hover:bg-bg-hover transition-colors duration-300">
                    <i class="lucide-arrow-left"></i> Back to Goals
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Goal Description -->
                @if($goal->description)
                    <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg">
                        <h5 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                            <i class="lucide-file-text text-neon-blue"></i> Description
                        </h5>
                        <p class="text-text-secondary leading-relaxed">{{ $goal->description }}</p>
                    </div>
                @endif

                <!-- Tasks List -->
                <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-neon-green to-neon-blue text-white p-4">
                        <div class="flex justify-between items-center">
                            <h5 class="text-lg font-semibold flex items-center gap-2">
                                <i class="lucide-list-checks"></i> Tasks 
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-white/20">{{ $goal->tasks->count() }}</span>
                            </h5>
                            <a href="{{ route('tasks.create') }}?section={{ $goal->section }}&goal_id={{ $goal->id }}" 
                               class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 hover:bg-white/30 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="lucide-plus-circle"></i> Add Task
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @forelse($goal->tasks as $task)
                            <div class="flex items-start gap-4 p-4 bg-bg-secondary/50 rounded-xl mb-3 last:mb-0 hover:bg-bg-secondary/70 transition-colors duration-200">
                                <div class="pt-1">
                                    <input class="task-checkbox w-5 h-5 text-neon-green bg-bg-secondary border-border-color rounded focus:ring-neon-green/50 cursor-pointer" 
                                           type="checkbox" 
                                           {{ $task->isCompleted() ? 'checked' : '' }}
                                           id="task-{{ $task->id }}"
                                           data-task-id="{{ $task->id }}">
                                </div>
                                <div class="flex-1">
                                    <label for="task-{{ $task->id }}" class="cursor-pointer">
                                        <h6 class="font-semibold text-text-primary mb-1 {{ $task->isCompleted() ? 'line-through text-text-muted' : '' }}">
                                            {{ $task->title }}
                                        </h6>
                                    </label>
                                    @if($task->description)
                                        <p class="text-text-secondary text-sm mb-2">{{ $task->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-3 text-sm">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $task->status === 'pending' ? 'bg-neon-yellow/20 text-neon-yellow' : 'bg-neon-green/20 text-neon-green' }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                        @if($task->due_date)
                                            <span class="text-text-secondary flex items-center gap-1">
                                                <i class="lucide-calendar text-xs"></i>
                                                {{ $task->due_date->format('M j, Y') }}
                                                @if($task->isOverdue())
                                                    <span class="text-neon-orange font-semibold">(Overdue)</span>
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('tasks.edit', $task) }}" 
                                       class="inline-flex items-center gap-1 p-2 text-neon-blue hover:bg-neon-blue/10 rounded-lg transition-colors duration-200">
                                        <i class="lucide-edit-2"></i>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 p-2 text-neon-orange hover:bg-neon-orange/10 rounded-lg transition-colors duration-200">
                                            <i class="lucide-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="lucide-inbox text-4xl text-text-muted mb-3"></i>
                                <p class="text-text-secondary">No tasks yet. Add your first task to start tracking progress!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Progress Card -->
                <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg">
                    <h5 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                        <i class="lucide-graph-up text-neon-green"></i> Progress
                    </h5>
                    <div class="text-center mb-4">
                        <div class="text-4xl font-bold mb-2 {{ $goal->progress >= 75 ? 'text-neon-green' : ($goal->progress >= 50 ? 'text-neon-yellow' : 'text-neon-orange') }}">
                            {{ number_format($goal->progress, 0) }}%
                        </div>
                        <p class="text-text-secondary text-sm">Completion Rate</p>
                    </div>
                    <div class="w-full bg-bg-secondary rounded-full h-6 overflow-hidden mb-3">
                        <div class="bg-gradient-to-r from-neon-green to-neon-blue h-full rounded-full transition-all duration-500" role="progressbar"
                            style="width: {{ $goal->progress }}%">
                        </div>
                    </div>
                    <p class="text-text-secondary text-sm text-center">
                        {{ $goal->tasks->where('status', 'completed')->count() }} of {{ $goal->tasks->count() }} tasks completed
                    </p>
                </div>

                <!-- Statistics Card -->
                <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg">
                    <h5 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                        <i class="lucide-bar-chart text-neon-blue"></i> Statistics
                    </h5>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-text-secondary text-sm">Total Tasks</span>
                            <span class="text-neon-blue font-semibold">{{ $goal->tasks->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-text-secondary text-sm">Pending</span>
                            <span class="text-neon-yellow font-semibold">{{ $goal->tasks->where('status', 'pending')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-text-secondary text-sm">Completed</span>
                            <span class="text-neon-green font-semibold">{{ $goal->tasks->where('status', 'completed')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-text-secondary text-sm">Overdue</span>
                            <span class="text-neon-orange font-semibold">{{ $goal->tasks->filter(fn($t) => $t->isOverdue())->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Goal Info Card -->
                <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg">
                    <h5 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                        <i class="lucide-info-circle text-text-muted"></i> Information
                    </h5>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-text-secondary">Time Period</span>
                            <span class="text-text-primary font-medium">{{ ucfirst($goal->section) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-secondary">Created</span>
                            <span class="text-text-primary">{{ $goal->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-secondary">Last Updated</span>
                            <span class="text-text-primary">{{ $goal->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const checkboxes = document.querySelectorAll('.task-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskId = this.dataset.taskId;
            
            fetch(`/tasks/${taskId}/toggle`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked;
                alert('Failed to update task status. Please try again.');
            });
        });
    });
});
</script>
@endpush
