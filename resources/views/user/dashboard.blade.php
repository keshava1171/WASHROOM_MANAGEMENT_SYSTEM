@extends('layouts.app')

@section('title', 'Public Dashboard - WMS')

@section('sidebar')
<div class="h-full flex flex-col justify-between">
    <div>
        <div class="mb-8">
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Your Portal</h3>
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl {{ request()->routeIs('dashboard') ? 'bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <i class="fas fa-home w-6"></i> Tracking Hub
                </a>
                
                <a href="{{ route('complaints.create') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl {{ request()->routeIs('complaints.create') ? 'bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <i class="fas fa-plus-circle w-6"></i> Report Issue
                </a>
                
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl {{ request()->routeIs('profile.edit') ? 'bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <i class="fas fa-user-circle w-6"></i> My Profile
                </a>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in-up">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">Welcome, {{ auth()->user()->name }}!</h1>
            <p class="text-slate-600 dark:text-slate-400">Track your verified facility incident reports</p>
        </div>
        
        <a href="{{ route('complaints.create') }}" class="btn-primary py-3 px-6 shadow-md shadow-primary-500/20 group">
            <i class="fas fa-bullhorn mr-2 group-hover:scale-110 transition-transform"></i>
            Log New Alert
        </a>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="premium-card p-8 border-l-8 border-l-slate-400 dark:border-l-slate-600 bg-white/80 dark:bg-slate-900/60 backdrop-blur-3xl">
            <div class="flex flex-col items-center justify-center py-4">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center text-xl mb-4 shadow-inner">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-2">{{ $userComplaints->count() }}</div>
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Total Reports</div>
            </div>
        </div>

        <div class="premium-card p-8 border-l-8 border-l-amber-500 bg-white/80 dark:bg-slate-900/60 backdrop-blur-3xl">
            <div class="flex flex-col items-center justify-center py-4">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-500/10 text-amber-500 flex items-center justify-center text-xl mb-4 shadow-inner">
                    <i class="fas fa-clock fa-spin-pulse"></i>
                </div>
                <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-2">{{ $userComplaints->where('status', 'pending')->count() }}</div>
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Awaiting Verification</div>
            </div>
        </div>

        <div class="premium-card p-8 border-l-8 border-l-emerald-500 bg-white/80 dark:bg-slate-900/60 backdrop-blur-3xl">
            <div class="flex flex-col items-center justify-center py-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xl mb-4 shadow-inner">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="text-4xl font-extrabold text-slate-900 dark:text-white mb-2">{{ $userComplaints->where('status', 'resolved')->count() }}</div>
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Closed Protocols</div>
            </div>
        </div>
    </div>

    
    <div class="premium-card p-6 animate-fade-in-up" style="animation-delay: 0.2s">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center">
            <i class="fas fa-list-ul w-6 text-primary-500"></i> Active Report Ledger
        </h2>
        
        <div class="space-y-4">
            @forelse($userComplaints as $complaint)
                <div class="bg-white/50 dark:bg-slate-800/40 backdrop-blur-2xl rounded-3xl p-8 border-[3px] border-slate-200 dark:border-slate-700/50 hover:border-indigo-500/50 transition-all shadow-xl hover:shadow-2xl">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                        
                        <div class="flex-1 space-y-4">
                            <div class="flex items-center gap-3">
                                <span class="status-badge {{ $complaint->status }}">
                                    @if($complaint->status == 'pending') <i class="fas fa-clock mr-1"></i>
                                    @elseif($complaint->status == 'in_progress') <i class="fas fa-tools mr-1"></i>
                                    @else <i class="fas fa-check-double mr-1"></i>
                                    @endif
                                    {{ str_replace('_', ' ', $complaint->status) }}
                                </span>
                                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center">
                                    <i class="fas fa-calendar-alt mr-1.5 opacity-70"></i>
                                    {{ $complaint->created_at->format('M d, Y') }}
                                </span>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2 mb-1">
                                    <i class="fas fa-crosshairs text-primary-500"></i>
                                    {{ $complaint->getLocationDisplay() }}
                                </h3>
                                <p class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed mt-2 pl-6 border-l-2 border-slate-200 dark:border-slate-700">
                                    {{ $complaint->message }}
                                </p>
                            </div>
                        </div>

                        
                        <div class="md:w-64 flex-none space-y-4">
                            @if($complaint->admin_notes)
                                <div class="p-3 bg-slate-100 dark:bg-slate-800/80 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 flex items-center"><i class="fas fa-comment-dots mr-1.5"></i> Operative Note</p>
                                    <p class="text-xs text-slate-700 dark:text-slate-300 font-medium">{{ $complaint->admin_notes }}</p>
                                </div>
                            @endif
                            
                            <a href="{{ route('complaints.show', $complaint) }}" class="block w-full text-center py-3 px-4 bg-white/80 dark:bg-slate-800 border-[3px] border-slate-200 dark:border-slate-700 rounded-2xl text-xs font-black text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-500 transition-all uppercase tracking-widest">
                                View Intelligence Log
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-16 text-center text-slate-500">
                    <div class="w-20 h-20 rounded-full bg-slate-100 dark:bg-slate-800 mx-auto flex items-center justify-center mb-6">
                        <i class="fas fa-clipboard-check text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Clean Ledger</h3>
                    <p class="text-sm">You haven't filed any issue reports yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

