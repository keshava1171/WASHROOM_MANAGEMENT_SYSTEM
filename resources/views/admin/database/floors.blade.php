@extends('layouts.app')

@section('title', 'Floors Database | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Structured Architecture</h1>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1">MySQL Database</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.database.floors.export') }}" class="btn-secondary py-2 px-4 shadow-sm text-[10px] font-black uppercase tracking-widest flex items-center gap-2 hover:text-emerald-500 transition-colors">
                <i class="fas fa-file-csv text-xs text-emerald-500"></i> Export CSV
            </a>
            <a href="{{ route('admin.structure') }}" class="btn-secondary py-2 px-6 text-[10px] font-black uppercase tracking-widest shadow-sm">
                <i class="fas fa-hammer mr-2 opacity-50"></i> Blueprint Tools
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
                        <th class="px-6 py-4">Lvl</th>
                        <th class="px-6 py-4">Context / Name</th>
                        <th class="px-6 py-4">Nodes</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @foreach($data as $floor)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20 group transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm animate-pulse shadow-emerald-500/20"></div>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Active</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-black text-xs text-indigo-500">
                            {{ $floor->level }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">{{ $floor->name }}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">{{ $floor->_id }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <span class="px-2 py-1 rounded bg-slate-100 dark:bg-slate-800 text-[9px] font-black text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                    {{ $floor->rooms->count() }} ROOMS
                                </span>
                                <span class="px-2 py-1 rounded bg-slate-100 dark:bg-slate-800 text-[9px] font-black text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                    {{ $floor->washrooms->count() }} UNITS
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-[10px] text-slate-500 font-bold uppercase tracking-widest">
                            {{ $floor->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                             <form action="{{ route('admin.structure.destroyFloor', $floor->id) }}" method="POST" onsubmit="return confirm('Cascade delete all assets on Level {{ $floor->level }}?')">
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

