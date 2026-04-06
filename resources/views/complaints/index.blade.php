@extends('layouts.app')

@section('title', 'My Complaints | WMS')

@section('content')
<div class="max-w-4xl mx-auto px-4 md:px-8 py-10 space-y-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-fade-in-up">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">My Complaints</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Track and manage your submitted reports</p>
        </div>
        <a href="{{ route('complaints.create') }}" class="btn-primary py-2.5 px-5 shadow-sm text-sm flex items-center gap-2 self-start sm:self-auto">
            <i class="fas fa-plus-circle"></i> New Report
        </a>
    </div>

    @if($complaints->isEmpty())
        <div class="premium-card p-16 text-center animate-fade-in-up">
            <div class="w-20 h-20 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-inbox text-4xl text-slate-300 dark:text-slate-600"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">No Complaints Yet</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-6">You haven't submitted any reports yet. If you notice an issue, let us know!</p>
            <a href="{{ route('complaints.create') }}" class="btn-primary py-2.5 px-6">
                <i class="fas fa-exclamation-triangle mr-2"></i> Report an Issue
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($complaints as $complaint)
                <div class="premium-card p-6 hover:-translate-y-0.5 transition-transform animate-fade-in-up">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-3 flex-wrap">
                                <span class="status-badge {{ $complaint->status }}">
                                    @if($complaint->status === 'pending') <i class="fas fa-clock mr-1.5"></i>
                                    @elseif($complaint->status === 'in_progress') <i class="fas fa-spinner mr-1.5"></i>
                                    @else <i class="fas fa-check-circle mr-1.5"></i>
                                    @endif
                                    {{ ucfirst(str_replace('_',' ', $complaint->status)) }}
                                </span>
                                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    {{ $complaint->created_at->format('M j, Y · g:i A') }}
                                </span>
                            </div>
                            <p class="text-slate-800 dark:text-slate-200 font-medium leading-relaxed mb-3">{{ $complaint->message }}</p>
                            <div class="flex flex-wrap gap-3 text-xs text-slate-500 dark:text-slate-400">
                                @if($complaint->floor)
                                    <span class="flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg">
                                        <i class="fas fa-layer-group text-primary-500"></i>
                                        {{ $complaint->floor->name ?? 'Unknown Floor' }}
                                    </span>
                                @endif
                                @if($complaint->room)
                                    <span class="flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg">
                                        <i class="fas fa-door-closed text-sky-500"></i>
                                        {{ $complaint->room->room_name ?? 'Unknown Room' }}
                                    </span>
                                @endif
                                @if($complaint->washroom)
                                    <span class="flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg">
                                        <i class="fas fa-restroom text-teal-500"></i>
                                        Washroom
                                    </span>
                                @endif
                            </div>
                            @if($complaint->staff_remark)
                                <div class="mt-4 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl p-4">
                                    <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-1">
                                        <i class="fas fa-comment-alt mr-1.5"></i> Staff Remark
                                    </p>
                                    <p class="text-sm text-emerald-800 dark:text-emerald-300">{{ $complaint->staff_remark }}</p>
                                    @if($complaint->handler_name)
                                        <p class="text-xs text-emerald-600/70 dark:text-emerald-500/70 mt-1">— {{ $complaint->handler_name }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('complaints.show', $complaint->id) }}" class="btn-secondary text-xs py-2 px-4 flex-shrink-0">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if($complaints->hasPages())
            <div class="flex justify-center">
                {{ $complaints->links() }}
            </div>
        @endif
    @endif
</div>
@endsection

