@extends('layouts.app')

@section('title', 'Progress & Analytics')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 pt-24">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl lg:text-5xl font-display font-bold text-text-primary mb-4">
                <i class="lucide-trending-up text-neon-green"></i>
                <span class="bg-gradient-to-r from-neon-pink to-neon-purple bg-clip-text text-transparent">Progress & Analytics</span>
            </h1>
            <p class="text-text-secondary text-lg">Track your productivity journey and celebrate achievements</p>
        </div>

        <!-- Stats Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Points Card -->
            <div class="bg-gradient-to-br from-neon-pink to-neon-purple text-white rounded-2xl shadow-2xl overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h6 class="text-white/80 font-semibold mb-2">Total Points</h6>
                            <div class="text-3xl font-bold">{{ number_format($stats->points ?? 0) }}</div>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <i class="lucide-gem text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Streak -->
            <div class="bg-gradient-to-br from-neon-yellow to-neon-orange text-white rounded-2xl shadow-2xl overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h6 class="text-white/80 font-semibold mb-2">Current Streak</h6>
                            <div class="text-3xl font-bold">🔥 {{ $stats->streak ?? 0 }}</div>
                            <div class="text-sm text-white/80">days</div>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <i class="lucide-flame text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Completed -->
            <div class="bg-gradient-to-br from-neon-green to-neon-blue text-white rounded-2xl shadow-2xl overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h6 class="text-white/80 font-semibold mb-2">Tasks Completed</h6>
                            <div class="text-3xl font-bold">{{ number_format($completedTasks) }}</div>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <i class="lucide-check-circle text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Goals Achieved -->
            <div class="bg-gradient-to-br from-neon-purple to-neon-teal text-white rounded-2xl shadow-2xl overflow-hidden hover:transform hover:scale-105 transition-all duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h6 class="text-white/80 font-semibold mb-2">Goals Achieved</h6>
                            <div class="text-3xl font-bold">{{ number_format($completedGoals) }}</div>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <i class="lucide-trophy text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Progress Chart -->
            <div class="lg:col-span-2 bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg">
                <div class="bg-gradient-to-r from-neon-green to-neon-blue text-white p-4 rounded-t-2xl">
                    <h5 class="text-lg font-semibold flex items-center gap-2">
                        <i class="lucide-line-chart"></i> Weekly Progress
                    </h5>
                </div>
                <div class="p-6">
                    <canvas id="progressChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg">
                <div class="bg-gradient-to-r from-neon-blue to-neon-cyan text-white p-4 rounded-t-2xl">
                    <h5 class="text-lg font-semibold flex items-center gap-2">
                        <i class="lucide-pie-chart"></i> Task Categories
                    </h5>
                </div>
                <div class="p-6">
                    <canvas id="categoryChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Achievements -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg mb-8">
            <div class="bg-gradient-to-r from-neon-yellow to-neon-orange text-white p-4 rounded-t-2xl">
                <h5 class="text-lg font-semibold flex items-center gap-2">
                    <i class="lucide-award"></i> Recent Achievements
                </h5>
            </div>
            <div class="p-6">
                @if($recentBadges->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($recentBadges as $badge)
                            <div class="bg-bg-secondary/50 border border-border-color rounded-xl p-4 text-center hover:transform hover:scale-105 hover:shadow-lg transition-all duration-300">
                                <div class="w-12 h-12 bg-gradient-to-br from-neon-green to-neon-blue rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                                    {{ $badge }}
                                </div>
                                <h6 class="text-text-primary font-semibold mb-1">Achievement Badge</h6>
                                <p class="text-text-secondary text-sm">Recent accomplishment</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="lucide-award text-5xl text-text-muted mb-4"></i>
                        <p class="text-text-secondary">No achievements yet. Keep completing tasks to unlock them!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Productivity Insights -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg">
            <div class="bg-gradient-to-r from-neon-yellow to-neon-orange text-white p-4 rounded-t-2xl">
                <h5 class="text-lg font-semibold flex items-center gap-2">
                    <i class="lucide-lightbulb"></i> Productivity Insights
                </h5>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-bg-secondary/50 rounded-xl p-4 hover:bg-bg-secondary/70 transition-colors duration-300">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="lucide-clock text-neon-blue"></i>
                            <h6 class="text-text-primary font-semibold">Most Productive Time</h6>
                        </div>
                        <p class="text-text-secondary">9:00 AM - 11:00 AM</p>
                    </div>

                    <div class="bg-bg-secondary/50 rounded-xl p-4 hover:bg-bg-secondary/70 transition-colors duration-300">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="lucide-calendar text-neon-cyan"></i>
                            <h6 class="text-text-primary font-semibold">Best Day</h6>
                        </div>
                        <p class="text-text-secondary">Wednesday</p>
                    </div>

                    <div class="bg-bg-secondary/50 rounded-xl p-4 hover:bg-bg-secondary/70 transition-colors duration-300">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="lucide-target text-neon-purple"></i>
                            <h6 class="text-text-primary font-semibold">Focus Area</h6>
                        </div>
                        <p class="text-text-secondary">Health & Fitness</p>
                    </div>

                    <div class="bg-bg-secondary/50 rounded-xl p-4 hover:bg-bg-secondary/70 transition-colors duration-300">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="lucide-zap text-neon-yellow"></i>
                            <h6 class="text-text-primary font-semibold">Productivity Score</h6>
                        </div>
                        <p class="text-text-secondary">87/100</p>
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
        document.querySelectorAll('.grid > div > div').forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-4px)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
@endpush
