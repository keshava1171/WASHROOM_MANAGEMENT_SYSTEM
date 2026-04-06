@extends('layouts.app')

@section('title', 'Complaints Database | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Diagnostic Audit Trail</h1>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">MySQL Database</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.complaints.export') }}" class="btn-secondary py-2 px-4 shadow-sm text-[10px] font-black uppercase tracking-widest flex items-center gap-2 hover:text-emerald-500 transition-colors">
                <i class="fas fa-file-csv text-xs text-emerald-500"></i> Export CSV
            </a>
            <a href="{{ route('admin.complaints') }}" class="btn-secondary py-2 px-6 text-[10px] font-black uppercase tracking-widest shadow-sm">
                <i class="fas fa-exclamation-triangle opacity-50 mr-2"></i> Case Management
            </a>
        </div>
    </div>

    @include('layouts.partials.flash-messages')

    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 transition-all overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] uppercase font-black tracking-widest text-slate-500">Status</th>
                        <th class="px-6 py-4 text-[10px] uppercase font-black tracking-widest text-slate-500">Origin / Unit</th>
                        <th class="px-6 py-4 text-[10px] uppercase font-black tracking-widest text-slate-500">Source Identity</th>
                        <th class="px-6 py-4 text-[10px] uppercase font-black tracking-widest text-slate-500">Description</th>
                        <th class="px-6 py-4 text-[10px] uppercase font-black tracking-widest text-slate-500">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @foreach($data as $complaint)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20 group transition-colors">
                        <td class="px-6 py-4">
                             <div class="status-badge {{ $complaint->status }} text-[10px] font-black">
                                <i class="fas fa-circle text-[6px] mr-1.5 shadow-sm"></i> {{ $complaint->status }}
                             </div>
                        </td>
                        <td class="px-6 py-4">
                             <div class="flex items-center gap-2">
                                <span class="bg-slate-500/10 text-slate-600 dark:text-slate-400 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest border border-slate-200 dark:border-slate-700">L{{ $complaint->floor->level ?? '?' }}</span>
                                <span class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-tight">
                                    {{ $complaint->room ? $complaint->room->room_number : ($complaint->washroom->room_number ?? 'PUBLIC UNIT') }}
                                </span>
                             </div>
                        </td>
                        <td class="px-6 py-4">
                             <div class="flex items-center gap-2 text-xs font-bold text-indigo-500 uppercase tracking-tight">
                                <i class="fas fa-id-badge opacity-50"></i> {{ $complaint->user->name ?? 'ANONYMOUS' }}
                             </div>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                             <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed font-medium truncate group-hover:whitespace-normal group-hover:overflow-visible transition-all">
                                {{ $complaint->description }}
                             </p>
                        </td>
                        <td class="px-6 py-4 text-[10px] text-slate-500 font-bold uppercase tracking-widest">
                            {{ $complaint->created_at->format('d M H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($data->hasPages())
        <div class="p-6 border-t border-slate-100 dark:border-slate-800">
            {{ $data->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

