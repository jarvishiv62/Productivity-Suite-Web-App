@extends('layouts.app')

@section('title', 'Calendar View')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 pt-24">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-8">
            <div class="flex-1">
                <h1 class="text-4xl lg:text-5xl font-display font-bold text-text-primary mb-2">
                    <i class="lucide-calendar text-neon-blue"></i> Calendar
                </h1>
                <p class="text-text-secondary">View all your tasks and diary entries in one place</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('tasks.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-neon-green to-neon-blue text-white font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                    <i class="lucide-plus-circle"></i> New Task
                </a>
                <a href="{{ route('diary.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-neon-purple to-neon-pink text-white font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                    <i class="lucide-journal-plus"></i> New Diary Entry
                </a>
            </div>
        </div>

        <!-- Legend -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg mb-6">
            <h6 class="text-lg font-semibold text-text-primary mb-4 flex items-center gap-2">
                <i class="lucide-palette text-neon-blue"></i> Legend
            </h6>
            <div class="flex flex-wrap gap-3">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-neon-blue/20 text-neon-blue">
                    <i class="lucide-circle text-xs"></i> Daily Tasks
                </span>
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-neon-yellow/20 text-neon-yellow">
                    <i class="lucide-circle text-xs"></i> Weekly Tasks
                </span>
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-neon-purple/20 text-neon-purple">
                    <i class="lucide-circle text-xs"></i> Monthly Tasks
                </span>
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-neon-green/20 text-neon-green">
                    <i class="lucide-circle text-xs"></i> Diary Entries
                </span>
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-neon-orange/20 text-neon-orange">
                    <i class="lucide-circle text-xs"></i> Overdue
                </span>
            </div>
        </div>

        <!-- Calendar -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50" id="eventModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div
                class="bg-bg-card border border-border-color rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
                <div class="bg-gradient-to-r from-neon-blue to-neon-purple text-white p-6">
                    <div class="flex justify-between items-center">
                        <h5 class="text-xl font-semibold">Event Details</h5>
                        <button type="button" onclick="closeEventModal()"
                            class="text-white/80 hover:text-white transition-colors">
                            <i class="lucide-x text-xl"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6" id="eventModalBody">
                    <!-- Event details will be loaded here -->
                </div>
                <div class="bg-bg-secondary border-t border-border-color p-6">
                    <div class="flex justify-between items-center">
                        <button type="button" onclick="closeEventModal()"
                            class="px-4 py-2 bg-bg-secondary border border-border-color text-text-secondary rounded-lg hover:bg-bg-hover transition-colors duration-300">
                            Close
                        </button>
                        <a href="#" id="eventEditLink"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-neon-green to-neon-blue text-white font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300"
                            style="display: none;">
                            <i class="lucide-edit-2"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <style>
        .fc {
            background: transparent;
        }

        .fc-toolbar-title {
            color: #f5f5f5;
        }

        .fc-button-primary {
            background: linear-gradient(135deg, #2196f3 0%, #9c27b0 100%);
            border: none;
            color: white;
        }

        .fc-button-primary:hover {
            background: linear-gradient(135deg, #1976d2 0%, #7b1fa2 100%);
        }

        .fc-daygrid-day-number {
            color: #f5f5f5;
        }

        .fc-theme-standard .fc-scrollgrid {
            border-color: #2f2f4e;
        }

        .fc-theme-standard th {
            border-color: #2f2f4e;
            background: #252542;
            color: #b0bec5;
        }

        .fc-theme-standard td {
            border-color: #2f2f4e;
        }

        .fc-event {
            border: none !important;
            padding: 2px 4px !important;
            font-size: 12px !important;
        }

        .modal {
            display: block !important;
        }

        .modal.hidden {
            display: none !important;
        }
    </style>
@endpush

@push('scripts')
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const eventModal = document.getElementById('eventModal');
            const eventModalBody = document.getElementById('eventModalBody');
            const eventEditLink = document.getElementById('eventEditLink');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: "{{ route('calendar.events') }}",
                eventClick: function (info) {
                    info.jsEvent.preventDefault();

                    const event = info.event;
                    const extendedProps = event.extendedProps;

                    let modalContent = '';

                    // Build modal content based on event type
                    if (extendedProps.type === 'task') {
                        modalContent = `
                            <div class="mb-4">
                                <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-neon-blue/20 text-neon-blue">
                                    <i class="lucide-check-square text-xs"></i> Task
                                </span>
                                <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full ${extendedProps.status === 'completed' ? 'bg-neon-green/20 text-neon-green' : 'bg-neon-yellow/20 text-neon-yellow'} ml-2">
                                    ${extendedProps.status}
                                </span>
                            </div>
                            <h4 class="text-xl font-semibold text-text-primary mb-3">${event.title}</h4>
                            ${extendedProps.description ? `<p class="text-text-secondary mb-3">${extendedProps.description}</p>` : ''}
                            ${extendedProps.goal ? `<div class="mb-3"><strong class="text-text-primary">Goal:</strong> <span class="text-neon-green">${extendedProps.goal}</span></div>` : ''}
                            <div class="text-text-secondary">
                                <div class="mb-2"><strong>Date:</strong> ${event.start ? event.start.toLocaleDateString() : 'N/A'}</div>
                                ${event.start && event.end ? `<div><strong>Time:</strong> ${event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div>` : ''}
                            </div>
                        `;

                        // Set edit link
                        const taskId = event.id.replace('task-', '');
                        eventEditLink.href = `/tasks/${taskId}/edit`;
                        eventEditLink.style.display = 'inline-flex';

                    } else if (extendedProps.type === 'diary') {
                        modalContent = `
                            <div class="mb-4">
                                <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-neon-green/20 text-neon-green">
                                    <i class="lucide-book-open text-xs"></i> Diary Entry
                                </span>
                                ${extendedProps.wordCount ? `<span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-neon-blue/20 text-neon-blue ml-2">${extendedProps.wordCount} words</span>` : ''}
                            </div>
                            <h4 class="text-xl font-semibold text-text-primary mb-3">${event.title}</h4>
                            ${extendedProps.content ? `<p class="text-text-secondary mb-3">${extendedProps.content}</p>` : ''}
                            <div class="text-text-secondary">
                                <div><strong>Date:</strong> ${event.start ? event.start.toLocaleDateString() : 'N/A'}</div>
                            </div>
                        `;

                        // Set edit link
                        const diaryId = event.id.replace('diary-', '');
                        eventEditLink.href = `/diary/${diaryId}/edit`;
                        eventEditLink.style.display = 'inline-flex';
                    }

                    eventModalBody.innerHTML = modalContent;
                    eventModal.classList.remove('hidden');
                },
                eventDidMount: function (info) {
                    // Add tooltip
                    info.el.title = info.event.title;
                },
                height: 'auto',
                aspectRatio: 1.8,
                nowIndicator: true,
                navLinks: true,
                businessHours: true,
                editable: false,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
            });

            calendar.render();
        });

        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('eventModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeEventModal();
            }
        });
    </script>
@endpush