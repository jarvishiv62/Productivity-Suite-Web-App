@extends('layouts.app')

@section('title', 'Dashboard - DailyDrive')

@section('content')
<div class="container">
    <!-- Motivational Quote Section -->
    @if($quote)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card quote-card glow-animation">
                    <div class="card-body text-center py-4">
                        <i class="lucide-quote display-4 mb-3"></i>
                        <h4 class="quote-content mb-3">"{{ $quote->content }}"</h4>
                        @if($quote->author)
                            <p class="quote-author mb-0">— {{ $quote->author }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-5 mb-2">
                        <i class="lucide-activity" style="color: var(--neon-green);"></i> 
                        <span style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Dashboard</span>
                    </h1>
                    <p class="text-muted mb-0">
                        <i class="lucide-calendar"></i> 
                        {{ now()->format('l, F j, Y') }} 
                        <span class="badge bg-secondary ms-2" id="current-time">{{ now()->format('h:i A') }}</span>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                        <i class="lucide-plus"></i> Quick Task
                    </a>
                    <a href="{{ route('goals.create') }}" class="btn btn-secondary">
                        <i class="lucide-target"></i> New Goal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="nav-tabs" id="sectionTabs" role="tablist">
                <div class="nav-item" role="presentation">
                    <button class="nav-link active" id="daily-tab" data-bs-toggle="tab" data-bs-target="#daily" type="button" role="tab">
                        <i class="lucide-sun"></i> 
                        <span>Daily</span>
                        <span class="badge bg-primary" style="background: var(--neon-green-muted); color: var(--text-primary);">{{ $dailyTasks->where('status', 'pending')->count() }}</span>
                    </button>
                </div>
                <div class="nav-item" role="presentation">
                    <button class="nav-link" id="weekly-tab" data-bs-toggle="tab" data-bs-target="#weekly" type="button" role="tab">
                        <i class="lucide-calendar"></i> 
                        <span>Weekly</span>
                        <span class="badge bg-primary" style="background: var(--neon-blue-muted); color: var(--text-primary);">{{ $weeklyTasks->where('status', 'pending')->count() }}</span>
                    </button>
                </div>
                <div class="nav-item" role="presentation">
                    <button class="nav-link" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab">
                        <i class="lucide-calendar-days"></i> 
                        <span>Monthly</span>
                        <span class="badge bg-primary" style="background: var(--neon-purple-muted); color: var(--text-primary);">{{ $monthlyTasks->where('status', 'pending')->count() }}</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="sectionTabContent">
                <!-- Daily Tab -->
                <div class="tab-pane fade show active" id="daily" role="tabpanel">
                    @include('partials.section-content', [
                        'section' => 'daily',
                        'tasks' => $dailyTasks,
                        'goals' => $dailyGoals
                    ])
                </div>

                <!-- Weekly Tab -->
                <div class="tab-pane fade" id="weekly" role="tabpanel">
                    @include('partials.section-content', [
                        'section' => 'weekly',
                        'tasks' => $weeklyTasks,
                        'goals' => $weeklyGoals
                    ])
                </div>

                <!-- Monthly Tab -->
                <div class="tab-pane fade" id="monthly" role="tabpanel">
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