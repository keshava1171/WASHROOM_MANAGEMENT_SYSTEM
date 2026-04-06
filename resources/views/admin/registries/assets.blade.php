@extends('layouts.app')

@section('title', 'Asset DB | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('custom_css')
<style>
    .scrollbar-premium::-webkit-scrollbar {
        width: 4px;
    }
    .scrollbar-premium::-webkit-scrollbar-track {
        background: transparent;
    }
    .scrollbar-premium::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.2);
        border-radius: 20px;
    }
    .scrollbar-premium::-webkit-scrollbar-thumb:hover {
        background: rgba(99, 102, 241, 0.5);
    }
</style>
@endsection

@section('content')
<div class="space-y-6 pb-20">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-tighter">Asset Database</h1>
            <p class="text-slate-600 dark:text-slate-400 text-sm font-bold uppercase tracking-widest opacity-60">Full index of facility floors, rooms, and units.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary px-4 py-2 text-xs font-bold uppercase tracking-widest bg-slate-100 dark:bg-slate-800 border-2 border-slate-200">
            <i class="fas fa-arrow-left mr-2"></i> Dashboard
        </a>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up">
        <div class="premium-card p-6 bg-indigo-500/10 border-indigo-500/20">
            <div class="flex items-center justify-between">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500">Total Floors</div>
                <i class="fas fa-layer-group text-2xl text-indigo-500/40"></i>
            </div>
            <div class="text-4xl font-black text-slate-900 dark:text-white mt-2">{{ $floors->count() }}</div>
        </div>
        <div class="premium-card p-6 bg-rose-500/10 border-rose-500/20">
            <div class="flex items-center justify-between">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-500">Total Rooms</div>
                <i class="fas fa-hospital text-2xl text-rose-500/40"></i>
            </div>
            <div class="text-4xl font-black text-slate-900 dark:text-white mt-2">{{ $rooms->count() }}</div>
        </div>
        <div class="premium-card p-6 bg-emerald-500/10 border-emerald-500/20">
            <div class="flex items-center justify-between">
                <div class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500">Public Units</div>
                <i class="fas fa-restroom text-2xl text-emerald-500/40"></i>
            </div>
            <div class="text-4xl font-black text-slate-900 dark:text-white mt-2">{{ $washrooms->where('type', 'public')->count() }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="premium-card flex flex-col max-h-[550px]">
            <div class="p-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-500 shrink-0">Facility Floors</div>
            <div class="overflow-auto scrollbar-premium flex-1">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-100 dark:bg-slate-800 text-[9px] font-black uppercase tracking-widest text-slate-400">
                            <th class="px-4 py-3 text-left">Level</th>
                            <th class="px-4 py-3 text-left">Floor Name</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($floors as $floor)
                            <tr>
                                <td class="px-4 py-3 font-black text-indigo-500">L{{ $floor->level == 0 ? 'G' : $floor->level }}</td>
                                <td class="px-4 py-3 font-bold text-slate-700 dark:text-slate-300">{{ $floor->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="premium-card flex flex-col max-h-[550px]">
            <div class="p-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-500 shrink-0">Maintenance Units (Washrooms)</div>
            <div class="overflow-auto scrollbar-premium flex-1">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-100 dark:bg-slate-800 text-[9px] font-black uppercase tracking-widest text-slate-400">
                            <th class="px-4 py-3 text-left">Name / No.</th>
                            <th class="px-4 py-3 text-left">Type</th>
                            <th class="px-4 py-3 text-left">Linkage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($washrooms as $washroom)
                            <tr>
                                <td class="px-4 py-3 font-bold text-slate-700 dark:text-slate-300">{{ $washroom->room_number ?: $washroom->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded border border-slate-200 dark:border-slate-700 text-slate-500">
                                        {{ $washroom->type }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-[10px] font-bold text-slate-400">
                                    {{ $washroom->room ? 'ATTACHED: ' . $washroom->room->room_number : 'PUBLIC' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

