@extends('layouts.app')

@section('title', 'My Diary')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 pt-24">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-8">
            <div class="flex-1">
                <h1 class="text-4xl lg:text-5xl font-display font-bold text-text-primary mb-2">
                    <i class="lucide-journal-text text-neon-purple"></i> My Diary
                </h1>
                <p class="text-text-secondary">Your personal thoughts and reflections</p>
            </div>
            <a href="{{ route('diary.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-neon-purple to-neon-pink text-white font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                <i class="lucide-plus-circle"></i> New Entry
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg mb-6">
            <form method="GET" action="{{ route('diary.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="lucide-search text-text-muted"></i>
                    </div>
                    <input type="text" class="w-full pl-10 pr-4 py-3 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-neon-purple/50 focus:border-neon-purple transition-all duration-300" 
                        name="search" placeholder="Search diary entries..." value="{{ request('search') }}">
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="lucide-calendar text-text-muted"></i>
                    </div>
                    <input type="date" class="w-full pl-10 pr-4 py-3 bg-bg-secondary/80 border border-border-color rounded-xl text-text-primary focus:outline-none focus:ring-2 focus:ring-neon-purple/50 focus:border-neon-purple transition-all duration-300" 
                        name="date" value="{{ request('date') }}">
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-neon-purple to-neon-pink text-white font-semibold rounded-xl hover:transform hover:scale-105 hover:shadow-lg transition-all duration-300">
                    <i class="lucide-search"></i> Search
                </button>
            </form>
        </div>

        @if($entries->isEmpty())
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-8 shadow-lg text-center">
                <i class="lucide-journal-plus text-6xl text-text-muted mb-4"></i>
                <h3 class="text-2xl font-semibold text-text-primary mb-2">No diary entries yet!</h3>
                <p class="text-text-secondary mb-4">Start documenting your thoughts and experiences.</p>
                <a href="{{ route('diary.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-neon-purple to-neon-pink text-white font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                    <i class="lucide-plus-circle"></i> Write Your First Entry
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($entries as $entry)
                    <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl p-6 shadow-lg hover:transform hover:scale-[1.02] transition-all duration-300">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <i class="lucide-calendar3 text-neon-purple"></i>
                                    <span class="text-text-secondary font-medium">
                                        {{ $entry->date->format('l, F j, Y') }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-neon-blue/20 text-neon-blue">
                                        {{ $entry->word_count }} words
                                    </span>
                                </div>
                                <h4 class="text-xl font-semibold text-text-primary mb-3">
                                    <a href="{{ route('diary.show', $entry) }}" class="text-decoration-none hover:text-neon-purple transition-colors duration-200">
                                        {{ $entry->title }}
                                    </a>
                                </h4>
                                <p class="text-text-secondary mb-3 leading-relaxed">{{ $entry->excerpt }}</p>
                                <div class="flex items-center gap-2 text-text-muted text-sm">
                                    <i class="lucide-clock"></i>
                                    <span>Created {{ $entry->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('diary.show', $entry) }}" class="inline-flex items-center gap-1 p-2 text-neon-blue hover:bg-neon-blue/10 rounded-lg transition-colors duration-200" title="View">
                                    <i class="lucide-eye"></i>
                                </a>
                                <a href="{{ route('diary.edit', $entry) }}" class="inline-flex items-center gap-1 p-2 text-neon-purple hover:bg-neon-purple/10 rounded-lg transition-colors duration-200" title="Edit">
                                    <i class="lucide-edit-2"></i>
                                </a>
                                <form action="{{ route('diary.destroy', $entry) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this diary entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 p-2 text-neon-orange hover:bg-neon-orange/10 rounded-lg transition-colors duration-200" title="Delete">
                                        <i class="lucide-trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="flex justify-center pt-6">
                    {{ $entries->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
