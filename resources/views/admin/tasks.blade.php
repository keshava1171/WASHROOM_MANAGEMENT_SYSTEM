@extends('layouts.app')

@section('title', 'Task Operations | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    
    <div class="animate-fade-in-up">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">Task Operations</h1>
        <p class="text-slate-600 dark:text-slate-400">Manage and oversee all assignments across the facility.</p>
    </div>

    
    <div class="premium-card p-4 animate-fade-in-up">
        <form class="flex flex-wrap items-center gap-4">
            <div class="relative flex-1 w-full md:w-auto min-w-[200px]">
                <i class="fas fa-search absolute left-4 top-3 text-slate-400"></i>
                <input type="text" placeholder="Search task ID or entity name..." 
                       class="input-premium pl-11 py-2 text-sm w-full">
            </div>
            
            <select class="input-premium py-2 text-sm w-full sm:w-40 bg-slate-50">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            
            <select class="input-premium py-2 text-sm w-full sm:w-40 bg-slate-50">
                <option value="">All Staff</option>
                @foreach($staff as $member)
                    <option value="{{ $member->_id }}">{{ $member->name }}</option>
                @endforeach
            </select>

            <button type="button" class="btn-primary py-2 px-6 shadow-sm text-sm whitespace-nowrap">
                <i class="fas fa-filter mr-2"></i> Apply Filter
            </button>
        </form>
    </div>

    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="premium-card p-4 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ $stats['pending'] }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Pending</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-500/20 flex items-center justify-center border border-amber-100 dark:border-amber-500/30">
                    <i class="fas fa-clock text-amber-500 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="premium-card p-4 animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ $stats['in_progress'] }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">In Progress</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-500/20 flex items-center justify-center border border-primary-100 dark:border-primary-500/30">
                    <i class="fas fa-spinner text-primary-500 text-xl fa-spin-pulse"></i>
                </div>
            </div>
        </div>
        <div class="premium-card p-4 animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ $stats['completed'] }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Completed</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/20 flex items-center justify-center border border-emerald-100 dark:border-emerald-500/30">
                    <i class="fas fa-check-double text-emerald-500 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="premium-card p-4 animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ $stats['total'] }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Total Tasks</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center border border-slate-200 dark:border-slate-600">
                    <i class="fas fa-tasks text-slate-500 dark:text-slate-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    
    <div class="premium-card animate-fade-in-up flex flex-col overflow-hidden" style="animation-delay: 0.5s">
        <div class="p-6 border-b border-slate-200 dark:border-dark-border flex items-center justify-between bg-white dark:bg-dark-surface">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center">
                <i class="fas fa-network-wired w-6 text-primary-500"></i> Operation Logs
                <span class="ml-3 text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $tasks->total() }} total</span>
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tasks.export') }}" class="text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors uppercase tracking-widest flex items-center">
                    <i class="fas fa-file-csv mr-2 text-sm"></i> Export CSV
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-dark-border">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pointer-events-none">Identifier Focus</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pointer-events-none">Personnel</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pointer-events-none">Current Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pointer-events-none">Dispatch Time</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest text-right pointer-events-none">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @forelse($tasks as $t)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-colors group">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                        <i class="fas {{ $t->room ? 'fa-bed text-primary-500' : 'fa-restroom text-secondary-500' }}"></i>
                                        {{ $t->room ? $t->room->room_name : ($t->washroom->room_number ?? 'Public Facility') }}
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-1">ID: #{{ substr($t->_id, 0, 8) }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($t->assignee)
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-700 uppercase tracking-wider">
                                        <i class="fas fa-user mr-2 text-slate-400"></i> {{ $t->assignee->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        <i class="fas fa-ghost mr-2 opacity-50"></i> Unassigned
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="status-badge {{ $t->status }}">
                                    @if($t->status === 'completed') <i class="fas fa-check-double mr-1.5"></i>
                                    @elseif($t->status === 'in_progress') <i class="fas fa-spinner fa-spin mr-1.5"></i>
                                    @else <i class="fas fa-clock mr-1.5"></i> @endif
                                    {{ str_replace('_', ' ', $t->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">
                                    {{ $t->created_at->format('M j, Y - H:i') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @if($t->status !== 'completed')
                                        <button onclick="completeTask('{{ $t->_id }}')" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-colors" title="Force Complete">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <form action="{{ route('admin.tasks.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Terminate this assignment?')" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Delete Task">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                <i class="fas fa-clipboard-check text-4xl mb-4 opacity-50 block"></i>
                                No assignments currently tracked in the database log.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tasks->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-slate-800/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                    Showing {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} of {{ $tasks->total() }} operations
                </div>
                <div>
                    {{ $tasks->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    async function completeTask(taskId) {
        if (!confirm('Mark this task as completed?')) return;
        
        try {
            const response = await fetch(`/admin/tasks/${taskId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            
            if (response.ok) {
                location.reload();
            } else {
                alert('Task finalization failure. The endpoint rejected the completion sequence.');
            }
        } catch (error) {
            alert('A network exception occurred while dispatching the completion command.');
        }
    }
</script>
@endsection

