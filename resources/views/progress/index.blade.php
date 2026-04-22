@extends('layouts.app')

@section('title', 'Progress & Analytics')

@section('content')
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="text-center mb-4">
                    <h1 class="display-5 mb-2">
                        <i class="lucide-trending-up" style="color: var(--neon-green);"></i>
                        <span
                            style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Progress
                            & Analytics</span>
                    </h1>
                    <p class="text-muted" style="font-size: 1.1rem;">Track your productivity journey and celebrate
                        achievements</p>
                </div>
            </div>
        </div>

        <!-- Stats Summary Cards -->
        <div class="row mb-4">
            <!-- Points Card -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card"
                    style="background: var(--primary-gradient); color: white; border: none; box-shadow: 0 8px 24px rgba(255, 0, 110, 0.3);">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h6
                                    style="color: rgba(255, 255, 255, 0.8); margin-bottom: var(--space-sm); font-weight: 600;">
                                    Total Points</h6>
                                <h2 style="margin-bottom: 0; font-weight: 700; font-size: 2.5rem;">
                                    {{ number_format($stats->points ?? 0) }}
                                </h2>
                            </div>
                            <div
                                style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                                <i class="lucide-gem" style="font-size: 28px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Streak -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card"
                    style="background: var(--accent-gradient); color: white; border: none; box-shadow: 0 8px 24px rgba(255, 190, 11, 0.3);">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h6
                                    style="color: rgba(255, 255, 255, 0.8); margin-bottom: var(--space-sm); font-weight: 600;">
                                    Current Streak</h6>
                                <h2 style="margin-bottom: 0; font-weight: 700; font-size: 2.5rem;">
                                    🔥 {{ $stats->streak ?? 0 }}
                                    <small style="font-size: 1rem; opacity: 0.8;">days</small>
                                </h2>
                            </div>
                            <div
                                style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                                <i class="lucide-flame" style="font-size: 28px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Completed -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card"
                    style="background: var(--secondary-gradient); color: var(--bg-primary); border: none; box-shadow: 0 8px 24px rgba(6, 255, 180, 0.3);">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h6 style="color: rgba(0, 0, 0, 0.6); margin-bottom: var(--space-sm); font-weight: 600;">
                                    Tasks Completed</h6>
                                <h2 style="margin-bottom: 0; font-weight: 700; font-size: 2.5rem;">
                                    {{ number_format($completedTasks) }}
                                </h2>
                            </div>
                            <div
                                style="width: 60px; height: 60px; background: rgba(0, 0, 0, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                                <i class="lucide-check-circle" style="font-size: 28px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Goals Achieved -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card"
                    style="background: linear-gradient(135deg, #8338EC 0%, #06FFB4 100%); color: white; border: none; box-shadow: 0 8px 24px rgba(131, 56, 236, 0.3);">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h6
                                    style="color: rgba(255, 255, 255, 0.8); margin-bottom: var(--space-sm); font-weight: 600;">
                                    Goals Achieved</h6>
                                <h2 style="margin-bottom: 0; font-weight: 700; font-size: 2.5rem;">
                                    {{ number_format($completedGoals) }}
                                </h2>
                            </div>
                            <div
                                style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                                <i class="lucide-trophy" style="font-size: 28px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row mb-4">
            <!-- Progress Chart -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="lucide-line-chart" style="color: var(--neon-green);"></i>
                            <span style="color: var(--neon-green);">Weekly Progress</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="progressChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="lucide-pie-chart" style="color: var(--neon-blue);"></i>
                            <span style="color: var(--neon-blue);">Task Categories</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Achievements -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="lucide-award" style="color: #F7DC6F;"></i> 
                            <span style="color: #F7DC6F;">Recent Achievements</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($recentBadges->isNotEmpty())
                            <div style="display: flex; flex-wrap: wrap; gap: var(--space-md);">
                                @foreach($recentBadges as $badge)
                                    <div
                                        style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: var(--space-md); min-width: 200px; text-align: center; transition: var(--transition-normal);">
                                        <div
                                            style="width: 50px; height: 50px; background: var(--secondary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto var(--space-sm); font-size: 24px;">
                                            {{ $badge }}
                                        </div>
                                        <h6 style="color: var(--text-primary); margin-bottom: var(--space-xs); font-weight: 600;">
                                            Achievement Badge
                                        </h6>
                                        <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 0;">
                                            Recent accomplishment
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: var(--space-xl);">
                                <i class="lucide-award"
                                    style="font-size: 48px; color: var(--text-muted); margin-bottom: var(--space-md);"></i>
                                <p style="color: var(--text-secondary);">No achievements yet. Keep completing tasks to unlock
                                    them!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Productivity Insights -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="lucide-lightbulb" style="color: #FFC107;"></i> 
                            <span style="color: #FFC107;">Productivity Insights</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--space-lg);">
                            <div
                                style="background: var(--bg-secondary); border-radius: var(--radius-md); padding: var(--space-lg);">
                                <div
                                    style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-sm);">
                                    <i class="lucide-clock" style="color: var(--neon-blue);"></i>
                                    <h6 style="color: var(--text-primary); margin-bottom: 0;">Most Productive Time</h6>
                                </div>
                                <p style="color: var(--text-secondary); margin-bottom: 0;">9:00 AM - 11:00 AM</p>
                            </div>

                            <div
                                style="background: var(--bg-secondary); border-radius: var(--radius-md); padding: var(--space-lg);">
                                <div
                                    style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-sm);">
                                    <i class="lucide-calendar" style="color: var(--neon-cyan);"></i>
                                    <h6 style="color: var(--text-primary); margin-bottom: 0;">Best Day</h6>
                                </div>
                                <p style="color: var(--text-secondary); margin-bottom: 0;">Wednesday</p>
                            </div>

                            <div
                                style="background: var(--bg-secondary); border-radius: var(--radius-md); padding: var(--space-lg);">
                                <div
                                    style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-sm);">
                                    <i class="lucide-target" style="color: var(--neon-purple);"></i>
                                    <h6 style="color: var(--text-primary); margin-bottom: 0;">Focus Area</h6>
                                </div>
                                <p style="color: var(--text-secondary); margin-bottom: 0;">Health & Fitness</p>
                            </div>

                            <div
                                style="background: var(--bg-secondary); border-radius: var(--radius-md); padding: var(--space-lg);">
                                <div
                                    style="display: flex; align-items: center; gap: var(--space-sm); margin-bottom: var(--space-sm);">
                                    <i class="lucide-zap" style="color: var(--neon-yellow);"></i>
                                    <h6 style="color: var(--text-primary); margin-bottom: 0;">Productivity Score</h6>
                                </div>
                                <p style="color: var(--text-secondary); margin-bottom: 0;">87/100</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Progress Chart
        const progressCtx = document.getElementById('progressChart').getContext('2d');
        new Chart(progressCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Tasks Completed',
                    data: [12, 19, 15, 25, 22, 30, 28],
                    borderColor: '#06FFB4',
                    backgroundColor: 'rgba(6, 255, 180, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Goals Progress',
                    data: [8, 12, 10, 18, 15, 20, 18],
                    borderColor: '#FF006E',
                    backgroundColor: 'rgba(255, 0, 110, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#B8BCC8'
                        }
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#B8BCC8'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        },
                        ticks: {
                            color: '#B8BCC8'
                        }
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Work', 'Personal', 'Health', 'Learning', 'Other'],
                datasets: [{
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: [
                        '#FF006E',
                        '#8338EC',
                        '#06FFB4',
                        '#FFBE0B',
                        '#FB5607'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#B8BCC8',
                            padding: 20
                        }
                    }
                }
            }
        });

        // Add hover effects to achievement cards
        document.querySelectorAll('.card-body > div > div').forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 8px 24px rgba(6, 255, 180, 0.3)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    </script>
@endpush