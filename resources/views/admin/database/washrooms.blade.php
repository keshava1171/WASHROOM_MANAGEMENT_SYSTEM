@extends('layouts.app')

@section('title', 'Washrooms Database | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Sanitation Node Audit</h1>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">MySQL Database</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.database.washrooms.export') }}" class="btn-secondary py-2 px-4 shadow-sm text-[10px] font-black uppercase tracking-widest flex items-center gap-2 hover:text-emerald-500 transition-colors">
                <i class="fas fa-file-csv text-xs text-emerald-500"></i> Export CSV
            </a>
            <a href="{{ route('admin.structure') }}" class="btn-secondary py-2 px-6 text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-restroom opacity-50"></i> Asset Management
            </a>
        </div>
    </div>

    @include('layouts.partials.flash-messages')

    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 transition-all overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 text-[10px] uppercase font-black tracking-widest text-slate-500">
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Node ID</th>
                        <th class="px-6 py-4">Context Area</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Link Reference</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @foreach($data as $wr)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20 group transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm animate-pulse"></div>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest text-emerald-500">Online</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                             <p class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">{{ $wr->room_number }}</p>
                             <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest opacity-0 group-hover:opacity-100 hover:text-indigo-500 transition-all truncate italic max-w-[100px]">{{ $wr->_id }}</p>
                        </td>
                        <td class="px-6 py-4">
                             <div class="flex items-center gap-2">
                                <span class="bg-slate-500/10 text-slate-500 px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest">L{{ $wr->floor->level ?? '?' }}</span>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-tight">{{ $wr->floor->name ?? 'UNKNOWN SECTOR' }}</span>
                             </div>
                        </td>
                        <td class="px-6 py-4">
                             <span class="px-3 py-1 rounded-full text-[9px] font-black border {{ $wr->type === 'public' ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-100 dark:border-indigo-500/20' : 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-500/20' }} uppercase tracking-widest shadow-sm">
                                {{ $wr->type }} Node
                             </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($wr->room_id)
                                <div class="flex items-center gap-2 text-indigo-500 text-[10px] font-black uppercase tracking-widest">
                                    <i class="fas fa-link-slash opacity-50"></i> P-{{ $wr->room->room_number ?? 'X' }}
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                                    <i class="fas fa-globe opacity-50"></i> Public Asset
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                             <form action="{{ route('admin.structure.destroyWashroom', $wr->id) }}" method="POST" onsubmit="return confirm('Terminate asset node {{ $wr->room_number }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors opacity-0 group-hover:opacity-100">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                             </form>
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

