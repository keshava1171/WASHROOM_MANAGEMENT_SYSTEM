@extends('layouts.app')

@section('title', 'Admin Command Center | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="px-6 py-8 space-y-10 animate-fade-in pb-32">
    
    
    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight uppercase">Command Center</h1>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1">Operational Facility Blueprint & Deployment</p>
        </div>
        <div class="flex items-center gap-3">
            
            <a href="{{ route('admin.print') }}" target="_blank"
               class="px-5 py-2.5 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-[10px] font-black uppercase tracking-[0.15em] shadow-lg hover:scale-105 active:scale-95 transition-all flex items-center gap-2 group"
               title="Print Cleaning Paper — Full facility maintenance manifest">
                <i class="fas fa-broom group-hover:rotate-12 transition-transform"></i>
                Print Cleaning Paper
            </a>
            
            <a href="{{ route('admin.complaints.print_all') }}" target="_blank"
               class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-white text-[10px] font-black uppercase tracking-[0.15em] shadow-lg hover:scale-105 active:scale-95 transition-all flex items-center gap-2 group"
               title="Print Complaint Paper — Facility-wide incident reports">
                <i class="fas fa-file-alt group-hover:rotate-6 transition-transform"></i>
                Print Complaint Paper
            </a>

            <a href="{{ route('admin.create-staff') }}"
               class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-[10px] font-black uppercase tracking-[0.15em] shadow-lg hover:scale-105 active:scale-95 transition-all flex items-center gap-2 group"
               title="Personnel recruitment and credentialing">
                <i class="fas fa-user-plus group-hover:scale-110 transition-transform"></i>
                Hire Staff
            </a>

            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-widest">System Online</span>
            </div>
        </div>

    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stat_items = [
                ['label' => 'Total Operations', 'val' => $stats['total_tasks'], 'icon' => 'fa-list-check', 'color' => 'indigo'],
                ['label' => 'Active Deployments', 'val' => $stats['pending_tasks'], 'icon' => 'fa-person-running', 'color' => 'amber'],
                ['label' => 'Completed Units', 'val' => $stats['completed_tasks'], 'icon' => 'fa-check-double', 'color' => 'emerald'],
                ['label' => 'Pending Alerts', 'val' => $stats['total_complaints'], 'icon' => 'fa-triangle-exclamation', 'color' => 'rose'],
            ];
        @endphp
        @foreach($stat_items as $item)
            <div class="premium-card p-6 flex items-center justify-between !rounded-3xl hover:scale-[1.02] transition-transform duration-300">
                <div>
                    <p class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1">{{ $item['label'] }}</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">{{ $item['val'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-{{ $item['color'] }}-500/10 text-{{ $item['color'] }}-500 flex items-center justify-center text-xl border border-{{ $item['color'] }}-500/20">
                    <i class="fas {{ $item['icon'] }}"></i>
                </div>
            </div>
        @endforeach
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.registry.users') }}" class="premium-card p-6 flex flex-col items-center justify-center text-center hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:border-indigo-500/50 transition-all group">
            <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-users-cog"></i>
            </div>
            <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-900 dark:text-white">Users Registry</h4>
            <p class="text-[10px] font-bold text-slate-400 mt-1">Manage personnel and roles</p>
        </a>

        <a href="{{ route('admin.registry.logs') }}" class="premium-card p-6 flex flex-col items-center justify-center text-center hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:border-indigo-500/50 transition-all group">
            <div class="w-14 h-14 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-900 dark:text-white">Operation Logs</h4>
            <p class="text-[10px] font-bold text-slate-400 mt-1">Full maintenance audit trail</p>
        </a>

        <a href="{{ route('admin.registry.assets') }}" class="premium-card p-6 flex flex-col items-center justify-center text-center hover:bg-slate-50 dark:hover:bg-slate-800/40 hover:border-indigo-500/50 transition-all group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-file-invoice"></i>
            </div>
            <h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-900 dark:text-white">Asset DB</h4>
            <p class="text-[10px] font-bold text-slate-400 mt-1">Floor & Unit blueprint index</p>
        </a>
    </div>

    
    <div class="premium-card p-8">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200/60 dark:border-indigo-500/20">
            <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight flex items-center gap-3">
                <i class="fas fa-layer-group text-indigo-500"></i> Facility Blueprint
            </h3>
            <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest">
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-slate-800 border border-slate-700"></span> Idle / Active</div>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-indigo-600"></span> Target</div>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-emerald-500"></span> Success</div>
            </div>
        </div>

        
        <div class="max-h-[65vh] overflow-y-auto scrollbar-tactical pr-4 space-y-4 pb-12">
            @foreach($floors as $floor)
                <div id="floor-{{ $floor->id }}" class="group/floor relative p-6 rounded-[2rem] bg-slate-50/50 dark:bg-slate-800/20 border-2 border-slate-200/50 dark:border-slate-700/30 hover:bg-white dark:hover:bg-slate-800/40 hover:border-indigo-500/30 transition-all duration-500 shadow-sm hover:shadow-2xl">
                    
                    
                    <div class="flex items-center justify-between cursor-default">
                        <div class="flex items-center gap-6">
                            <span class="px-4 py-2 bg-slate-100 dark:bg-slate-900 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl border-2 border-slate-200 dark:border-slate-800 shadow-inner">LEVEL {{ $floor->level == 0 ? 'G' : $floor->level }}</span>
                            <div>
                                <h4 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-[0.15em] mb-1">{{ $floor->name }}</h4>
                                <div class="flex items-center gap-3">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                        <i class="fas fa-cubes opacity-50"></i> {{ $floor->rooms->count() }} PRIVATE NODES
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                        <i class="fas fa-droplet opacity-50"></i> {{ $floor->washrooms->where('room_id', null)->count() }} PUBLIC UNITS
                                    </span>
                                </div>
                            </div>
                        </div>
 
                        <div class="flex items-center gap-3">
                            <button onclick="bulkSelectFloorUnits('floor-grid-{{ $floor->id }}', this)" class="px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-[10px] font-black text-indigo-500 uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all mr-2">
                                Select Floor Nodes
                            </button>
                            <a href="{{ route('admin.structure') }}" class="w-10 h-10 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white flex items-center justify-center transition-all shadow-lg shadow-indigo-600/20 group/btn" title="Edit Floor Segment">
                                <i class="fas fa-edit text-sm group-hover/btn:scale-110 transition-transform"></i>
                            </a>
                            <form action="{{ route('admin.structure.destroyFloor', $floor->id) }}" method="POST" onsubmit="return confirm('Eradicate entire floor segment?')" data-ajax-form data-delete-target="floor-{{ $floor->id }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-10 h-10 rounded-xl bg-rose-600 hover:bg-rose-500 text-white flex items-center justify-center transition-all shadow-lg shadow-rose-600/20 group/btn" title="Delete Floor Segment">
                                    <i class="fas fa-trash-alt text-sm group-hover/btn:scale-110 transition-transform"></i>
                                </button>
                            </form>
                            <div class="ml-4 w-8 h-8 rounded-full border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 group-hover/floor:border-indigo-500 group-hover/floor:text-indigo-500 transition-all">
                                <i class="fas fa-chevron-down text-[10px] group-hover/floor:rotate-180 transition-transform duration-500"></i>
                            </div>
                        </div>
                    </div>

                    
                    <div class="max-h-0 opacity-0 overflow-hidden group-hover/floor:max-h-[2000px] group-hover/floor:opacity-100 group-hover/floor:mt-8 transition-all duration-700 ease-in-out border-t border-slate-200/50 dark:border-slate-700/50">
                        <div class="grid grid-cols-[repeat(auto-fill,minmax(100px,1fr))] gap-5 pt-8 pb-4" id="floor-grid-{{ $floor->id }}">
                            @foreach($floor->rooms as $room)
                                <div id="room-{{ $room->id }}" 
                                     onclick="toggleSelection(this)"
                                     data-type="room"
                                     data-id="{{ $room->id }}"
                                     data-name="{{ $room->room_number }}"
                                     data-floor-id="{{ $floor->id }}"
                                     data-status="{{ $room->status }}"
                                     @php
                                        $bgClass = 'bg-slate-800 border-slate-700/50';
                                        $textClass = 'text-slate-400';
                                     @endphp
                                     data-idle-classes="asset-tile relative cursor-pointer rounded-2xl border-2 flex flex-col items-center justify-center gap-2 text-center transition-all {{ $bgClass }} {{ $textClass }}"
                                     class="asset-tile relative cursor-pointer rounded-2xl border-2 flex flex-col items-center justify-center gap-2 text-center transition-all {{ $bgClass }} {{ $textClass }} group/tile hover:scale-110 hover:z-30 hover:border-indigo-500/50 shadow-xl hover:shadow-indigo-500/10">
                                    
                                    <i class="fas fa-hospital text-xl opacity-40 group-hover/tile:opacity-100 group-hover/tile:text-indigo-400 transition-all"></i>
                                    <span class="text-xs font-black tracking-tight leading-none group-hover/tile:text-white">{{ $room->room_number }}</span>
                                    
                                    
                                    <div class="absolute top-1.5 right-1.5 flex gap-1 z-10 opacity-0 group-hover/tile:opacity-100 transition-opacity">
                                        <button onclick="event.stopPropagation(); window.location='{{ route('admin.structure') }}'" class="w-6 h-6 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-[9px] flex items-center justify-center shadow-lg"><i class="fas fa-edit"></i></button>
                                        <form action="{{ route('admin.structure.destroyRoom', $room->id) }}" method="POST" onsubmit="return confirm('Eradicate node?')" data-ajax-form data-delete-target="room-{{ $room->id }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="event.stopPropagation();" class="w-6 h-6 rounded-lg bg-rose-600 hover:bg-rose-500 text-white text-[9px] flex items-center justify-center shadow-lg"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            @foreach($floor->washrooms->where('room_id', null) as $washroom)
                                <div id="washroom-{{ $washroom->id }}"
                                     onclick="toggleSelection(this)"
                                     data-type="public"
                                     data-id="{{ $washroom->id }}"
                                     data-name="{{ $washroom->room_number }}"
                                     data-floor-id="{{ $floor->id }}"
                                     data-status="{{ $washroom->status }}"
                                     @php
                                        $bgClass = 'bg-slate-800 border-slate-700/50';
                                        $textClass = 'text-slate-400';
                                     @endphp
                                     data-idle-classes="asset-tile relative cursor-pointer rounded-2xl border-2 flex flex-col items-center justify-center gap-2 text-center transition-all {{ $bgClass }} {{ $textClass }}"
                                     class="asset-tile relative cursor-pointer rounded-2xl border-2 flex flex-col items-center justify-center gap-2 text-center transition-all {{ $bgClass }} {{ $textClass }} group/tile hover:scale-110 hover:z-30 hover:border-indigo-500/50 shadow-xl hover:shadow-indigo-500/10">
                                    
                                    <i class="fas @if($washroom->type == 'washroom') fa-restroom @else fa-droplet @endif text-xl opacity-40 group-hover/tile:opacity-100 group-hover/tile:text-indigo-400 transition-all"></i>
                                    <span class="text-xs font-black tracking-tight leading-none group-hover/tile:text-white">{{ $washroom->room_number }}</span>

                                    <div class="absolute top-1.5 right-1.5 flex gap-1 z-10 opacity-0 group-hover/tile:opacity-100 transition-opacity">
                                        <button onclick="event.stopPropagation(); window.location='{{ route('admin.structure') }}'" class="w-6 h-6 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-[9px] flex items-center justify-center shadow-lg"><i class="fas fa-edit"></i></button>
                                        <form action="{{ route('admin.structure.destroyWashroom', $washroom->id) }}" method="POST" onsubmit="return confirm('Eradicate washroom?')" data-ajax-form data-delete-target="washroom-{{ $washroom->id }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="event.stopPropagation();" class="w-6 h-6 rounded-lg bg-rose-600 hover:bg-rose-500 text-white text-[9px] flex items-center justify-center shadow-lg"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    </div>
</div>

<div id="tactical-tray" class="fixed bottom-0 left-0 lg:left-64 right-0 z-50 transform translate-y-full transition-all duration-500 p-6 pointer-events-none">
    <div class="max-w-5xl mx-auto bg-slate-900 dark:bg-white text-white dark:text-slate-900 p-6 rounded-2xl shadow-2xl flex flex-col md:flex-row items-center justify-between gap-6 pointer-events-auto border-2 border-indigo-500/30">
        <div class="flex items-center gap-6">
            <div class="flex flex-col text-center md:text-left">
                <span id="selected-count" class="text-4xl font-black tracking-tighter leading-none text-indigo-400">00</span>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] opacity-60">Nodes Selected</span>
            </div>
            <div class="hidden md:block w-px h-10 bg-slate-700 dark:bg-slate-200"></div>
            <div class="max-w-md">
                <p class="text-[10px] font-bold uppercase tracking-widest opacity-60 mb-1.5">Target Queue</p>
                <div id="selected-labels" class="flex flex-wrap gap-2 text-[10px] font-black uppercase tracking-widest text-indigo-300 dark:text-indigo-600">
                    
                </div>
            </div>
        </div>

        <form id="assignment-form" action="{{ route('admin.tasks.bulk') }}" method="POST" class="flex items-center gap-4 w-full md:w-auto" data-ajax-form>
            @csrf
            <div id="input-container"></div>
            
            <select name="assigned_to" required class="bg-slate-800 dark:bg-slate-100 text-white dark:text-slate-900 text-xs font-black border-none rounded-xl px-4 py-3 min-w-[180px] focus:ring-2 ring-indigo-500">
                <option value="">SELECT OPERATIVE</option>
                @foreach($staff as $member)
                    <option value="{{ $member->id }}">{{ strtoupper($member->name) }}</option>
                @endforeach
            </select>
 
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs uppercase tracking-widest py-3 px-8 rounded-xl transition-all shadow-lg shadow-indigo-600/30 flex items-center gap-3">
                <i class="fas fa-bolt"></i> Initiate Task
            </button>
        </form>
    </div>
</div>

<script>
    let selectedAssets = [];
 
    function toggleSelection(el, forceState = null, skipTrayUpdate = false) {
        const id = el.dataset.id;
        const type = el.dataset.type;
        const index = selectedAssets.findIndex(a => a.id === id && a.type === type);
        
        const isCurrentlySelected = index !== -1;
        const shouldBeSelected = forceState !== null ? forceState : !isCurrentlySelected;

        if (shouldBeSelected) {
            if (!isCurrentlySelected) {
                selectedAssets.push({ 
                    type: type, 
                    id: id, 
                    name: el.dataset.name, 
                    floor_id: el.dataset.floorId, 
                    el: el 
                });
                el.dataset.oldClasses = el.className;
                el.className = "asset-tile relative cursor-pointer rounded-2xl border-2 flex flex-col items-center justify-center gap-2 text-center transition-all bg-indigo-600 text-white border-indigo-500 shadow-lg shadow-indigo-600/30 scale-[1.02] z-20";
            }
        } else {
            if (isCurrentlySelected) {
                el.className = el.dataset.oldClasses || el.dataset.idleClasses;
                selectedAssets.splice(index, 1);
            }
        }
        
        if (!skipTrayUpdate) {
            updateTray();
            syncFloorButtonState(el.dataset.floorId);
        }
    }
 
    function bulkSelectFloorUnits(gridId, btn) {
        const grid = document.getElementById(gridId);
        const tiles = grid.querySelectorAll('.asset-tile');
        const floorId = gridId.split('-').pop();
        
        const allSelected = Array.from(tiles).every(tile => selectedAssets.some(a => a.el === tile));
        const finalState = !allSelected;

        tiles.forEach(tile => {
            toggleSelection(tile, finalState, true);
        });
        
        updateTray();
        syncFloorButtonState(floorId);
    }

    function syncFloorButtonState(floorId) {
        const gridId = `floor-grid-${floorId}`;
        const grid = document.getElementById(gridId);
        if (!grid) return;

        const tiles = grid.querySelectorAll('.asset-tile');
        const allSelected = Array.from(tiles).every(tile => selectedAssets.some(a => a.el === tile));
        
        const floorPanel = document.getElementById(`floor-${floorId}`);
        if (!floorPanel) return;

        const btn = floorPanel.querySelector('button[onclick*="bulkSelectFloorUnits"]');
        if (btn) {
            btn.innerText = allSelected ? "Unselect All Nodes" : "Select Floor Nodes";
        }
    }
 
    function updateTray() {
        const tray = document.getElementById('tactical-tray');
        const count = document.getElementById('selected-count');
        const labels = document.getElementById('selected-labels');
        const inputs = document.getElementById('input-container');
 
        count.innerText = selectedAssets.length.toString().padStart(2, '0');
        
        if (selectedAssets.length > 0) {
            tray.classList.remove('translate-y-full');
            labels.innerHTML = selectedAssets.map(a => `<span>${a.name}</span>`).join('<span class="opacity-30">•</span>');
            inputs.innerHTML = selectedAssets.map((a, i) => `
                <input type="hidden" name="selections[${i}][id]" value="${a.id}">
                <input type="hidden" name="selections[${i}][type]" value="${a.type}">
                <input type="hidden" name="selections[${i}][floor_id]" value="${a.floor_id}">
            `).join('');
        } else {
            tray.classList.add('translate-y-full');
        }
    }

    window.addEventListener('tactical-sync-success', (e) => {

        if (e.detail.form && e.detail.form.id === 'assignment-form') {
            selectedAssets.forEach(asset => {

                asset.el.className = "asset-tile relative cursor-pointer rounded-xl border-2 flex flex-col items-center justify-center gap-2 text-center transition-all bg-emerald-500 border-emerald-600 text-white shadow-lg scale-110 z-30";
                

                setTimeout(() => {
                    asset.el.className = asset.el.dataset.idleClasses;
                }, 1500);
            });
            selectedAssets = [];
            updateTray();
        }

        if (e.detail.targetId) {
            const target = document.getElementById(e.detail.targetId);

            selectedAssets = selectedAssets.filter(asset => {
                const stillExists = document.body.contains(asset.el);
                const insideDeleted = target && target.contains(asset.el);
                return stillExists && !insideDeleted;
            });
            updateTray();
        }
    });
</script>

<style>
    .asset-tile {
        aspect-ratio: 1 / 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    
    .scrollbar-tactical::-webkit-scrollbar {
        width: 6px;
        display: block !important;
    }
    .scrollbar-tactical::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.05);
        border-radius: 10px;
    }
    .scrollbar-tactical::-webkit-scrollbar-thumb {
        background: rgba(79, 70, 229, 0.4); 
        border-radius: 10px;
    }
    .scrollbar-tactical::-webkit-scrollbar-thumb:hover {
        background: rgba(79, 70, 229, 0.8);
    }
    
    
    .group\/floor-reveal:hover .max-h-0 {
        max-height: 2000px !important;
        opacity: 1 !important;
        margin-top: 1rem;
    }

    
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection

