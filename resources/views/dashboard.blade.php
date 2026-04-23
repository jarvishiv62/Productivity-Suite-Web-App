@extends('layouts.app')

@section('title', 'Dashboard - DailyDrive')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Motivational Quote Section -->
    @if($quote)
        <div class="flex flex-col lg:flex-row gap-4 mb-4">
            <div class="flex-1">
                <div class="bg-gradient-to-r from-neon-pink to-neon-purple border-none text-center rounded-2xl shadow-2xl overflow-hidden relative animate-glow p-6">
                        <i class="lucide-quote text-4xl mb-3 text-white"></i>
                        <h4 class="font-display text-xl font-semibold italic text-white mb-3 relative z-10">"{{ $quote->content }}"</h4>
                        @if($quote->author)
                            <p class="font-display font-semibold text-white opacity-90 mb-0 relative z-10">— {{ $quote->author }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Dashboard Header -->
    <div class="flex flex-col lg:flex-row gap-4 mb-6">
        <div class="flex-1">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                <div>
                    <h1 class="text-4xl lg:text-5xl font-display font-bold mb-2">
                        <i class="lucide-activity text-neon-green"></i> 
                        <span class="bg-gradient-to-r from-neon-pink to-neon-purple bg-clip-text text-transparent">Dashboard</span>
                    </h1>
                    <p class="text-text-secondary mb-0">
                        <i class="lucide-calendar"></i> 
                        {{ now()->format('l, F j, Y') }} 
                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-bg-tertiary text-text-primary ml-2" id="current-time">{{ now()->format('h:i A') }}</span>
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-neon-pink to-neon-purple text-white font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                        <i class="lucide-plus"></i> Quick Task
                    </a>
                    <a href="{{ route('goals.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-neon-green to-neon-blue text-bg-primary font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                        <i class="lucide-target"></i> New Goal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Tabs -->
    <div class="w-full">
        <div class="flex border-b-2 border-border-color mb-6 overflow-x-auto" id="sectionTabs" role="tablist">
                <div class="mb-[-2px]" role="presentation">
                    <button class="flex items-center gap-2 px-4 py-3 bg-transparent border-none border-b-3 border-transparent text-text-secondary font-semibold cursor-pointer transition-all duration-300 whitespace-nowrap hover:text-text-primary hover:bg-bg-hover active:text-neon-cyan active:border-neon-cyan active:bg-bg-hover" id="daily-tab" data-bs-toggle="tab" data-bs-target="#daily" type="button" role="tab">
                        <i class="lucide-sun"></i> 
                        <span>Daily</span>
                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-neon-green/15 text-text-primary ml-2">{{ $dailyTasks->where('status', 'pending')->count() }}</span>
                    </button>
                </div>
                <div class="mb-[-2px]" role="presentation">
                    <button class="flex items-center gap-2 px-4 py-3 bg-transparent border-none border-b-3 border-transparent text-text-secondary font-semibold cursor-pointer transition-all duration-300 whitespace-nowrap hover:text-text-primary hover:bg-bg-hover active:text-neon-cyan active:border-neon-cyan active:bg-bg-hover" id="weekly-tab" data-bs-toggle="tab" data-bs-target="#weekly" type="button" role="tab">
                        <i class="lucide-calendar"></i> 
                        <span>Weekly</span>
                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-neon-blue/15 text-text-primary ml-2">{{ $weeklyTasks->where('status', 'pending')->count() }}</span>
                    </button>
                </div>
                <div class="mb-[-2px]" role="presentation">
                    <button class="flex items-center gap-2 px-4 py-3 bg-transparent border-none border-b-3 border-transparent text-text-secondary font-semibold cursor-pointer transition-all duration-300 whitespace-nowrap hover:text-text-primary hover:bg-bg-hover active:text-neon-cyan active:border-neon-cyan active:bg-bg-hover" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab">
                        <i class="lucide-calendar-days"></i> 
                        <span>Monthly</span>
                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-neon-purple/15 text-text-primary ml-2">{{ $monthlyTasks->where('status', 'pending')->count() }}</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="min-h-[400px]" id="sectionTabContent">
                <!-- Daily Tab -->
                <div class="block animate-fade-in" id="daily" role="tabpanel">
                    @include('partials.section-content', [
                        'section' => 'daily',
                        'tasks' => $dailyTasks,
                        'goals' => $dailyGoals
                    ])
                </div>

                <!-- Weekly Tab -->
                <div class="hidden animate-fade-in" id="weekly" role="tabpanel">
                    @include('partials.section-content', [
                        'section' => 'weekly',
                        'tasks' => $weeklyTasks,
                        'goals' => $weeklyGoals
                    ])
                </div>

                <!-- Monthly Tab -->
                <div class="hidden animate-fade-in" id="monthly" role="tabpanel">
                    @include('partials.section-content', [
                        'section' => 'monthly',
                        'tasks' => $monthlyTasks,
                        'goals' => $monthlyGoals
                    ])
                </div>
            </div>
@endsection

@push('scripts')
<script>
    // Task toggle functionality
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const checkboxes = document.querySelectorAll('.task-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const taskId = this.dataset.taskId;
            const taskItem = this.closest('.task-item');
            const isChecked = this.checked;
            
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
                    // Update UI in real-time
                    if (isChecked) {
                        // Move to completed section
                        moveToCompleted(taskItem);
                    } else {
                        // Move back to pending section
                        moveToPending(taskItem);
                    }
                    updateProgressBars();
                    updateCounts();
                } else {
                    this.checked = !this.checked;
                    alert('Failed to update task status. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked;
                alert('Failed to update task status. Please try again.');
            });
        });
    });

    function moveToCompleted(taskItem) {
        const completedSection = document.querySelector('.divide-y.divide-border-color.opacity-70');
        if (completedSection) {
            // Add completed styling
            taskItem.style.opacity = '0.7';
            const checkbox = taskItem.querySelector('.task-checkbox');
            if (checkbox) {
                checkbox.checked = true;
                checkbox.disabled = true;
            }
            
            // Update label styling
            const label = taskItem.querySelector('h6');
            if (label) {
                label.style.textDecoration = 'line-through';
                label.classList.add('text-text-muted');
            }
            
            // Move to completed section
            completedSection.appendChild(taskItem);
        }
    }

    function moveToPending(taskItem) {
        const pendingSection = document.querySelector('.divide-y.divide-border-color:not(.opacity-70)');
        if (pendingSection) {
            // Remove completed styling
            taskItem.style.opacity = '1';
            const checkbox = taskItem.querySelector('.task-checkbox');
            if (checkbox) {
                checkbox.checked = false;
                checkbox.disabled = false;
            }
            
            // Update label styling
            const label = taskItem.querySelector('h6');
            if (label) {
                label.style.textDecoration = 'none';
                label.classList.remove('text-text-muted');
            }
            
            // Move to pending section
            pendingSection.appendChild(taskItem);
        }
    }

    function updateProgressBars() {
        // Update sidebar progress bar
        const sidebarProgress = document.querySelector('[data-goal-id="sidebar-progress"]');
        if (sidebarProgress) {
            const totalTasks = document.querySelectorAll('.task-item').length;
            const completedTasks = document.querySelectorAll('.task-item[style*="opacity: 0.7"]').length;
            const percentage = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;
            
            sidebarProgress.style.width = percentage + '%';
            sidebarProgress.textContent = percentage + '%';
            
            // Update the text below the progress bar
            const progressText = sidebarProgress.closest('.bg-bg-card/80').querySelector('.text-text-secondary');
            if (progressText) {
                progressText.textContent = `${completedTasks} of ${totalTasks} tasks completed`;
            }
        }
        
        // Update all progress bars in goals section
        document.querySelectorAll('[role="progressbar"][data-goal-id]').forEach(progressBar => {
            const goalId = progressBar.dataset.goalId;
            if (goalId && goalId !== 'sidebar-progress') {
                // Count tasks for this specific goal
                const goalTasks = document.querySelectorAll(`.task-item[data-goal-id="${goalId}"]`);
                const goalCompletedTasks = document.querySelectorAll(`.task-item[data-goal-id="${goalId}"][style*="opacity: 0.7"]`);
                const progress = goalTasks.length > 0 ? Math.round((goalCompletedTasks.length / goalTasks.length) * 100) : 0;
                
                progressBar.style.width = progress + '%';
                
                // Update percentage text
                const percentageText = progressBar.closest('.bg-bg-secondary/50').querySelector('.text-white');
                if (percentageText) {
                    percentageText.textContent = progress + '%';
                }
            }
        });
    }

    function updateCounts() {
        // Update task counts in headers
        const pendingCount = document.querySelectorAll('.task-item:not([style*="opacity: 0.7"])').length;
        const completedCount = document.querySelectorAll('.task-item[style*="opacity: 0.7"]').length;
        
        // Update pending count in the header
        const pendingBadges = document.querySelectorAll('.text-neon-yellow');
        pendingBadges.forEach(badge => {
            if (badge.textContent.includes('Pending')) {
                const parent = badge.closest('.flex');
                if (parent) {
                    const countSpan = parent.querySelector('.inline-flex');
                    if (countSpan) {
                        countSpan.textContent = pendingCount;
                    }
                }
            }
        });
        
        // Update completed count in the header
        const completedBadges = document.querySelectorAll('.bg-white\\/20');
        completedBadges.forEach(badge => {
            badge.textContent = completedCount;
        });
        
        // Update quick stats
        const statsContainer = document.querySelector('.space-y-3');
        if (statsContainer) {
            const pendingStat = statsContainer.querySelector('.text-neon-yellow.font-semibold');
            const completedStat = statsContainer.querySelector('.text-neon-cyan.font-semibold');
            
            if (pendingStat) pendingStat.textContent = pendingCount;
            if (completedStat) completedStat.textContent = completedCount;
        }
    }

    // Update time every minute
    function updateCurrentTime() {
        const now = new Date();
        let hours = now.getHours();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        const minutes = now.getMinutes().toString().padStart(2, '0');
        
        const timeElement = document.getElementById('current-time');
        if (timeElement) {
            timeElement.textContent = `${hours}:${minutes} ${ampm}`;
        }
    }
    
    // Update time immediately and then every minute
    updateCurrentTime();
    setInterval(updateCurrentTime, 60000);
</script>
@endpush