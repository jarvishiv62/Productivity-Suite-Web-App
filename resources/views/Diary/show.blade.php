@extends('layouts.app')

@section('title', $diary->title)

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8 pt-24">
        <div class="max-w-4xl mx-auto">
            <!-- Header Actions -->
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-6">
                <a href="{{ route('diary.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-bg-secondary border border-border-color text-text-secondary rounded-lg hover:bg-bg-hover transition-colors duration-300">
                    <i class="lucide-arrow-left"></i> Back to Diary
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('diary.edit', $diary) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-neon-purple to-neon-pink text-white font-semibold rounded-lg hover:transform hover:translate-y-[-2px] hover:shadow-lg transition-all duration-300">
                        <i class="lucide-edit-2"></i> Edit
                    </a>
                    <form action="{{ route('diary.destroy', $diary) }}" method="POST" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this diary entry?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-neon-orange/20 border border-neon-orange text-neon-orange font-semibold rounded-lg hover:bg-neon-orange/30 transition-colors duration-300">
                            <i class="lucide-trash-2"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Entry Card -->
            <div class="bg-bg-card/80 backdrop-blur-xl border border-border-color rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-neon-purple to-neon-pink text-white p-6">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-white/20">
                            <i class="lucide-calendar3"></i>
                            {{ $diary->date->format('l, F j, Y') }}
                        </span>
                        <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold rounded-full bg-white/20">
                            <i class="lucide-file-text"></i>
                            {{ $diary->word_count }} words
                        </span>
                    </div>
                    <h2 class="text-2xl lg:text-3xl font-bold font-display">{{ $diary->title }}</h2>
                </div>
                
                <div class="p-6 lg:p-8">
                    <!-- Content -->
                    <div class="diary-content prose prose-invert max-w-none">
                        {!! nl2br(e($diary->content)) !!}
                    </div>

                    <!-- Metadata -->
                    <div class="mt-8 pt-6 border-t border-border-color">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-text-secondary text-sm">
                            <div class="flex items-center gap-2">
                                <i class="lucide-clock"></i>
                                <span>Created {{ $diary->created_at->format('M j, Y \a\t g:i A') }}</span>
                            </div>
                            @if($diary->updated_at != $diary->created_at)
                                <div class="flex items-center gap-2">
                                    <i class="lucide-edit-3"></i>
                                    <span>Last edited {{ $diary->updated_at->diffForHumans() }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .diary-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #f5f5f5;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .diary-content p {
            margin-bottom: 1.5rem;
        }
        
        .dark .diary-content {
            color: #f5f5f5;
        }
    </style>
@endpush
