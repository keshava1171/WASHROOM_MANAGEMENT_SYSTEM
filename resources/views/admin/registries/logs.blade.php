@extends('layouts.app')

@section('title', 'Operation Logs | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Operation Logs</h1>
            <p class="text-slate-600 dark:text-slate-400 text-sm">Full audit trail of all maintenance and cleaning protocols.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary px-4 py-2 text-xs font-bold uppercase tracking-widest bg-slate-100 dark:bg-slate-800">
            <i class="fas fa-arrow-left mr-2"></i> Dashboard
        </a>
    </div>

    
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Log ID</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Operative</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Location</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Protocol Status</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 text-right">Date & Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 text-xs font-black text-slate-400 italic">#TXN-{{ str_pad($task->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user-circle text-slate-300"></i>
                                    <span class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $task->user->name ?? 'System Node' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-800 dark:text-white mb-0.5">
                                    {{ $task->floor->name ?? 'Unmapped Floor' }}
                                </div>
                                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                    {{ $task->room ? $task->room->room_number : ($task->washroom ? ($task->washroom->room_number ?? 'PUBLIC UNIT') : 'GENERAL AREA') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest 
                                    {{ $task->status === 'completed' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-amber-500/10 text-amber-500' }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="text-sm font-bold text-slate-500 dark:text-slate-400">{{ $task->created_at->format('M d, Y') }}</div>
                                <div class="text-[10px] text-slate-400">{{ $task->created_at->format('H:i:s') }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center opacity-40 italic text-slate-500 uppercase tracking-widest text-xs font-black">No operational logs detected in database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tasks->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/30">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

