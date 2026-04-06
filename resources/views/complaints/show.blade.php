@extends('layouts.app')

@section('title', 'Complaint Details | WMS')

@section('content')
<div class="max-w-3xl mx-auto px-4 md:px-8 py-10 animate-fade-in-up">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('complaints.index') }}" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Complaint Details</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">Submitted {{ $complaint->created_at->diffForHumans() }}</p>
        </div>
    </div>

    <div class="premium-card p-8 space-y-6">
        
        <div class="flex items-center justify-between">
            <span class="status-badge {{ $complaint->status }} text-sm">
                @if($complaint->status === 'pending') <i class="fas fa-clock mr-1.5"></i>
                @elseif($complaint->status === 'in_progress') <i class="fas fa-spinner mr-1.5"></i>
                @else <i class="fas fa-check-circle mr-1.5"></i>
                @endif
                {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
            </span>
            <span class="text-xs text-slate-400 dark:text-slate-500">{{ $complaint->created_at->format('M j, Y · g:i A') }}</span>
        </div>

        
        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-5 space-y-3 border border-slate-200 dark:border-slate-700">
            <h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Location</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-xs text-slate-400 mb-1">Floor</span>
                    <span class="font-bold text-slate-900 dark:text-white">{{ $complaint->floor->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-xs text-slate-400 mb-1">Room</span>
                    <span class="font-bold text-slate-900 dark:text-white">{{ $complaint->room->room_name ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        
        <div>
            <h4 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">Report</h4>
            <p class="text-slate-800 dark:text-slate-200 leading-relaxed text-sm">{{ $complaint->message }}</p>
        </div>

        
        @if($complaint->staff_remark)
            <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl p-5">
                <h4 class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest mb-2">
                    <i class="fas fa-reply mr-1.5"></i> Staff Response
                </h4>
                <p class="text-sm text-emerald-800 dark:text-emerald-300">{{ $complaint->staff_remark }}</p>
                @if($complaint->handler_name)
                    <p class="text-xs text-emerald-600/70 dark:text-emerald-500/70 mt-2 font-medium">— {{ $complaint->handler_name }}</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

