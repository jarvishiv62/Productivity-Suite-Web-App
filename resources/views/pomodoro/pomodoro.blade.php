@extends('layouts.app')

@section('title', 'Pomodoro Timer - DailyDrive')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 pt-24">
        <div class="max-w-4xl mx-auto">
            <!-- Timer Card -->
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-neon-orange to-neon-red text-white p-6 text-center">
                    <h2 class="text-3xl font-bold mb-2 font-display flex items-center justify-center gap-3">
                        <span class="text-4xl">🍅</span> Pomodoro Timer
                    </h2>
                    <p class="text-white/80">Focus for 25 minutes, break for 5</p>
                </div>

                <div class="p-8 text-center">
                    <!-- Session Type Badge -->
                    <div class="mb-6">
                        <span class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full {{ $session->getSessionColor() === 'success' ? 'bg-neon-green/20 text-neon-green' : ($session->getSessionColor() === 'warning' ? 'bg-neon-yellow/20 text-neon-yellow' : ($session->getSessionColor() === 'info' ? 'bg-neon-blue/20 text-neon-blue' : 'bg-neon-purple/20 text-neon-purple')) }}">
                            {{ $session->getSessionType() }} Session
                        </span>
                    </div>

                    <!-- Timer Display -->
                    <div class="timer-display mb-6">
                        <div class="text-6xl lg:text-7xl font-bold text-text-primary font-mono tabular-nums" id="timer">
                            {{ $session->getFormattedTime() }}
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-6">
                        <div class="w-full bg-bg-secondary rounded-full h-2 overflow-hidden">
                            <div id="progressBar" class="h-full rounded-full transition-all duration-1000 {{ $session->getSessionColor() === 'success' ? 'bg-neon-green' : ($session->getSessionColor() === 'warning' ? 'bg-neon-yellow' : ($session->getSessionColor() === 'info' ? 'bg-neon-blue' : 'bg-neon-purple')) }}"
                                role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>

                    <!-- Control Buttons -->
                    <div class="timer-controls mb-6 flex justify-center gap-3">
                        <button id="startBtn" class="inline-flex items-center gap-2 px-6 py-3 bg-neon-green text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-lg transition-all duration-300">
                            <i class="lucide-play"></i> Start
                        </button>
                        <button id="pauseBtn" class="inline-flex items-center gap-2 px-6 py-3 bg-neon-yellow text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-lg transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed" disabled>
                            <i class="lucide-pause"></i> Pause
                        </button>
                        <button id="resetBtn" class="inline-flex items-center gap-2 px-6 py-3 bg-neon-orange text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-lg transition-all duration-300">
                            <i class="lucide-rotate-ccw"></i> Reset
                        </button>
                    </div>

                    <!-- Task Selection -->
                    <div class="task-selection mb-6 text-left">
                        <label for="taskSelect" class="block text-sm font-medium text-text-secondary mb-2">
                            <i class="lucide-list-checks text-neon-orange"></i>
                            Link to Daily Task (Optional)
                        </label>
                        <select id="taskSelect" class="w-full px-4 py-3 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary focus:outline-none focus:ring-2 focus:ring-neon-orange/50 focus:border-neon-orange transition-all duration-300">
                            <option value="">No task selected</option>
                            @foreach($dailyTasks as $task)
                                <option value="{{ $task->id }}" {{ $session->task_id == $task->id ? 'selected' : '' }}>
                                    {{ $task->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Current Session Info -->
                    <div class="session-info">
                        <div class="bg-neon-blue/10 border border-neon-blue/30 rounded-xl p-4">
                            <div class="flex items-center gap-2 text-neon-blue text-sm">
                                <i class="lucide-info-circle"></i>
                                <span id="sessionInfo">
                                    @if($session->isRunning())
                                        Timer running since {{ $session->started_at->format('h:i A') }}
                                    @else
                                        Ready to start a focus session
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg mt-6">
                <h6 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                    <i class="lucide-lightbulb text-neon-yellow"></i> Pomodoro Tips
                </h6>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-text-secondary text-sm">
                    <div class="flex items-start gap-2">
                        <i class="lucide-check-circle text-neon-orange mt-0.5"></i>
                        <span>Work in focused 25-minute sessions</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="lucide-check-circle text-neon-orange mt-0.5"></i>
                        <span>Take 5-minute breaks between sessions</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="lucide-check-circle text-neon-orange mt-0.5"></i>
                        <span>After 4 sessions, take a longer break</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class="lucide-check-circle text-neon-orange mt-0.5"></i>
                        <span>Eliminate distractions during work time</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Complete Modal -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50" id="sessionCompleteModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-bg-card border border-border-color rounded-2xl shadow-2xl max-w-md w-full">
                <div class="bg-gradient-to-r from-neon-green to-neon-blue text-white p-6 text-center">
                    <h5 class="text-xl font-semibold">Session Complete! 🎉</h5>
                </div>
                <div class="p-6 text-center">
                    <div class="text-2xl font-semibold text-text-primary mb-3" id="completeMessage"></div>
                    <p class="text-text-secondary">Take a moment to stretch and hydrate</p>
                </div>
                <div class="bg-bg-secondary border-t border-border-color p-6 text-center">
                    <button type="button" onclick="closeSessionModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-neon-green to-neon-blue text-white font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .timer-display {
            font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
            font-variant-numeric: tabular-nums;
            letter-spacing: 0.05em;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        button:disabled:hover {
            transform: none !important;
            box-shadow: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/pomodoro.js') }}"></script>
    <script>
        function closeSessionModal() {
            document.getElementById('sessionCompleteModal').classList.add('hidden');
        }

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.code === 'Space' && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
                const startBtn = document.getElementById('startBtn');
                const pauseBtn = document.getElementById('pauseBtn');
                
                if (startBtn.disabled) {
                    pauseBtn.click();
                } else {
                    startBtn.click();
                }
            }
            
            if (e.code === 'KeyR' && e.ctrlKey) {
                e.preventDefault();
                document.getElementById('resetBtn').click();
            }
        });
    </script>
@endpush
