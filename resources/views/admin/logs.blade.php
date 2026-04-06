@extends('layouts.app')

@section('title', 'System operation logs | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 animate-fade-in-up">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">Operation Logs</h1>
            <p class="text-slate-600 dark:text-slate-400">Complete historical record of system task executions</p>
        </div>
        <div class="flex gap-4">
            <button class="btn-secondary py-3 px-6 shadow-sm">
                <i class="fas fa-file-export mr-2"></i> Export Data
            </button>
        </div>
    </div>

    <div class="premium-card overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-dark-border">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Time</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Task ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Operative</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Target Location</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50 text-sm">
                    @forelse($tasks as $t)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20">
                            <td class="px-6 py-4 font-mono text-xs text-slate-500 dark:text-slate-400">
                                {{ $t->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-primary-600 dark:text-primary-400">
                                #{{ substr($t->_id, 0, 8) }}
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-700 dark:text-slate-300">
                                {{ $t->assignee->name ?? 'SYSTEM AUTO' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-900 dark:text-white">{{ $t->room ? $t->room->room_name : ($t->washroom->room_number ?? 'Public Washroom') }}</span>
                                    <span class="text-xs text-slate-500 uppercase tracking-widest">{{ $t->floor->name ?? 'General' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="status-badge {{ $t->status }}">
                                    {{ str_replace('_', ' ', $t->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">No logs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(method_exists($tasks, 'hasPages') && $tasks->hasPages())
            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-dark-border">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

