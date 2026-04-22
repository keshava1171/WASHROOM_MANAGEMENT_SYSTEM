@extends('layouts.app')

@section('title', 'Operations Dashboard | Staff | WMS')

@section('sidebar')
    @include('staff.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 pb-24">
    
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-6 animate-fade-in-up">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-bold text-xs uppercase tracking-widest mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Sensor Feed Active
            </div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">Operations Matrix</h1>
            <p class="text-slate-600 dark:text-slate-400">Assigned protocol execution and finalization node.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('staff.print') }}" target="_blank"
               class="btn-secondary px-5 py-3 shadow-sm group text-center"
               title="Print daily cleaning schedule (Maintenance Manifest)">
                <i class="fas fa-broom mr-2 group-hover:text-primary-500 transition-colors"></i>
                Print Cleaning Paper
            </a>
            <a href="{{ route('staff.complaints.print_all') }}" target="_blank"
               class="btn-secondary px-5 py-3 shadow-sm group text-center border-amber-300 dark:border-amber-700 text-amber-700 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20"
               title="Print all current active complaints in the facility">
                <i class="fas fa-file-alt mr-2 group-hover:text-amber-500 transition-colors"></i>
                Print Complaint Paper
            </a>
            <a href="{{ route('staff.complaints') }}" class="btn-primary px-5 py-3 shadow-sm group">
                <i class="fas fa-satellite-dish mr-2 group-hover:animate-ping"></i> Issue Radar
            </a>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @php
            $staff_stats = [
                ['label' => 'Total Assignments', 'val' => $tasks->flatten()->count(), 'icon' => 'fa-clipboard-list', 'color' => 'indigo', 'glow' => 'rgba(79,70,229,0.3)'],
                ['label' => 'Neuralized Units',  'val' => $stats['completed_tasks'] ?? 0, 'icon' => 'fa-check-double', 'color' => 'emerald', 'glow' => 'rgba(16,185,129,0.3)'],
                ['label' => 'Active Uplinks',    'val' => $stats['pending_tasks'] ?? 0, 'icon' => 'fa-clock', 'color' => 'amber', 'glow' => 'rgba(245,158,11,0.3)'],
                ['label' => 'Critical Sectors',  'val' => $stats['in_progress_tasks'] ?? 0, 'icon' => 'fa-bolt', 'color' => 'rose', 'glow' => 'rgba(244,63,94,0.3)'],
            ];
        @endphp
        @foreach($staff_stats as $index => $item)
            <div class="premium-card p-8 animate-fade-in-up group relative overflow-hidden" style="animation-delay: {{ $index * 0.1 }}s; box-shadow: 0 0 40px {{ $item['glow'] }}">
                <div class="absolute -right-10 -bottom-10 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110 duration-700">
                    <i class="fas {{ $item['icon'] }} text-[12rem] text-{{ $item['color'] }}-500"></i>
                </div>
                <div class="relative z-10 flex items-center justify-between mb-6">
                    <div class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 dark:text-slate-400 group-hover:text-{{ $item['color'] }}-500 transition-colors">{{ $item['label'] }}</div>
                    <div class="w-12 h-12 rounded-2xl bg-{{ $item['color'] }}-500/10 text-{{ $item['color'] }}-500 flex items-center justify-center shadow-inner border border-{{ $item['color'] }}-500/20 group-hover:bg-{{ $item['color'] }}-500 group-hover:text-white transition-all transform group-hover:rotate-12">
                        <i class="fas {{ $item['icon'] }} text-lg"></i>
                    </div>
                </div>
                <div class="relative z-10 text-5xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $item['val'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- ============================================================
         EXECUTION GRID — mirrors admin facility blueprint
         ============================================================ --}}
    <div class="premium-card p-8">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200/60 dark:border-indigo-500/20">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-3 tracking-tight">
                <i class="fas fa-microchip text-indigo-500"></i> Execution Grid
            </h3>
            <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest hidden sm:flex">
                <div class="flex items-center gap-1.5 text-[#64748b]"><span class="w-3 h-3 rounded-sm bg-slate-800 border border-slate-700"></span> No Task</div>
                <div class="flex items-center gap-1.5 text-[#64748b]"><span class="w-3 h-3 rounded-sm bg-amber-500"></span> Assigned</div>
                <div class="flex items-center gap-1.5 text-[#64748b]"><span class="w-3 h-3 rounded-sm bg-indigo-600"></span> Selected</div>
                <div class="flex items-center gap-1.5 text-[#64748b]"><span class="w-3 h-3 rounded-sm bg-emerald-500"></span> Done</div>
            </div>
        </div>

        <div class="max-h-[65vh] overflow-y-auto scrollbar-tactical pr-4 space-y-4 pb-12">
            @forelse($floors as $floor)
                @php
                    $slug = $floor->id;
                    $publicWashrooms = $floor->washrooms->where('room_id', null);
                @endphp
                <div id="floor-{{ $slug }}" class="group/floor relative p-6 rounded-[2rem] bg-slate-50/50 dark:bg-slate-800/20 border-2 border-slate-200/50 dark:border-slate-700/30 hover:bg-white dark:hover:bg-slate-800/40 hover:border-indigo-500/30 transition-all duration-500 shadow-sm hover:shadow-2xl">

                    <div class="flex items-center justify-between cursor-default">
                        <div class="flex items-center gap-6">
                            <span class="px-4 py-2 bg-slate-100 dark:bg-slate-900 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl border-2 border-slate-200 dark:border-slate-800 shadow-inner">
                                LEVEL {{ $floor->level == 0 ? 'G' : $floor->level }}
                            </span>
                            <div>
                                <h4 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-[0.15em] mb-1">{{ $floor->name }}</h4>
                                <div class="flex items-center gap-3">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                        <i class="fas fa-cubes opacity-50"></i> {{ $floor->rooms->count() }} PRIVATE NODES
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                                        <i class="fas fa-droplet opacity-50"></i> {{ $publicWashrooms->count() }} PUBLIC UNITS
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button onclick="event.stopPropagation(); bulkSelectFloorUnits('floor-grid-{{ $slug }}', this)"
                                    class="px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-[10px] font-black text-indigo-500 uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all mr-2">
                                Select Floor Nodes
                            </button>
                            <div class="w-8 h-8 rounded-full border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 group-hover/floor:border-indigo-500 group-hover/floor:text-indigo-500 transition-all">
                                <i class="fas fa-chevron-down text-[10px] group-hover/floor:rotate-180 transition-transform duration-500"></i>
                            </div>
                        </div>
                    </div>

                    <div class="max-h-0 opacity-0 overflow-hidden group-hover/floor:max-h-[2000px] group-hover/floor:opacity-100 group-hover/floor:mt-8 transition-all duration-700 ease-in-out border-t border-slate-200/50 dark:border-slate-700/50">
                        @if($floor->rooms->isNotEmpty() || $publicWashrooms->isNotEmpty())
                            <div class="grid grid-cols-[repeat(auto-fill,minmax(100px,1fr))] gap-5 pt-8 pb-4" id="floor-grid-{{ $slug }}">

                                {{-- ── ROOM TILES ── --}}
                                @foreach($floor->rooms as $room)
                                    @php
                                        $hasTask = !is_null($room->taskId);
                                        $bgClass   = $hasTask ? 'bg-amber-500/20 border-amber-500/50' : 'bg-slate-800 border-slate-700/50';
                                        $textClass = $hasTask ? 'text-amber-300' : 'text-slate-500';
                                        $idleClasses = "asset-tile relative rounded-2xl border-2 flex flex-col items-center justify-center gap-2 text-center transition-all {$bgClass} {$textClass}";
                                    @endphp
                                    <div id="room-{{ $room->id }}"
                                         data-type="room"
                                         data-id="{{ $room->id }}"
                                         data-task-id="{{ $room->taskId ?? '' }}"
                                         data-name="{{ $room->room_number }}"
                                         data-floor-id="{{ $slug }}"
                                         data-has-task="{{ $hasTask ? '1' : '0' }}"
                                         data-idle-classes="{{ $idleClasses }}"
                                         onclick="toggleSelection(this)"
                                         class="{{ $idleClasses }} cursor-pointer group/tile hover:scale-110 hover:z-30 hover:border-indigo-500/50 shadow-xl hover:shadow-indigo-500/10">
                                        <i class="fas fa-hospital text-xl {{ $hasTask ? 'opacity-70 group-hover/tile:opacity-100 group-hover/tile:text-indigo-400' : 'opacity-40 group-hover/tile:text-indigo-400' }} transition-all"></i>
                                        <span class="text-xs font-black tracking-tight leading-none group-hover/tile:text-white">{{ $room->room_number }}</span>
                                        @if($hasTask)
                                            <span class="absolute top-1.5 left-1.5 w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                        @endif
                                    </div>
                                @endforeach

                                    {{-- ── PUBLIC WASHROOM TILES ── --}}
                                    @foreach($publicWashrooms as $washroom)
                                        @php
                                            $hasTask = !is_null($washroom->taskId);
                                            $bgClass   = $hasTask ? 'bg-amber-500/20 border-amber-500/50' : 'bg-slate-800 border-slate-700/50';
                                            $textClass = $hasTask ? 'text-amber-300' : 'text-slate-500';
                                            $idleClasses = "asset-tile relative rounded-2xl border-2 flex flex-col items-center justify-center gap-2 text-center transition-all {$bgClass} {$textClass}";
                                        @endphp
                                        <div id="washroom-{{ $washroom->id }}"
                                             data-type="public"
                                             data-id="{{ $washroom->id }}"
                                             data-task-id="{{ $washroom->taskId ?? '' }}"
                                             data-name="{{ $washroom->room_number }}"
                                         data-floor-id="{{ $slug }}"
                                         data-has-task="{{ $hasTask ? '1' : '0' }}"
                                         data-idle-classes="{{ $idleClasses }}"
                                         onclick="toggleSelection(this)"
                                         class="{{ $idleClasses }} cursor-pointer group/tile hover:scale-110 hover:z-30 hover:border-indigo-500/50 shadow-xl hover:shadow-indigo-500/10">
                                        <i class="fas fa-droplet text-xl {{ $hasTask ? 'opacity-70 group-hover/tile:opacity-100 group-hover/tile:text-indigo-400' : 'opacity-40 group-hover/tile:text-indigo-400' }} transition-all"></i>
                                        <span class="text-xs font-black tracking-tight leading-none group-hover/tile:text-white">{{ $washroom->room_number }}</span>
                                        @if($hasTask)
                                            <span class="absolute top-1.5 left-1.5 w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                        @endif
                                    </div>
                                @endforeach

                            </div>
                        @else
                            <div class="py-8 text-center opacity-40 pt-8">
                                <p class="text-xs font-bold uppercase tracking-widest text-slate-500">No units on this floor</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-32 flex flex-col items-center justify-center text-center opacity-40">
                    <i class="fas fa-ghost text-7xl text-slate-400 dark:text-slate-500 mb-6"></i>
                    <h3 class="text-2xl font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400">Grid Empty</h3>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── EXECUTION COMMAND TRAY ── --}}
<div id="execution-command-tray" class="fixed bottom-0 left-0 lg:left-64 right-0 z-50 transition-all duration-500 transform translate-y-full px-4 pb-6 pointer-events-none">
    <div class="max-w-4xl mx-auto bg-slate-900 dark:bg-slate-950 backdrop-blur-xl border border-indigo-400/30 rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.5)] p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between pointer-events-auto gap-4">
        
        <div class="flex items-center gap-6">
            <div class="flex flex-col items-center sm:items-start text-center sm:text-left">
                <div id="execution-counter" class="text-4xl font-black text-indigo-400 tracking-tight leading-none mb-1">00</div>
                <div class="text-[9px] font-black uppercase tracking-widest text-indigo-500/70">Nodes Selected</div>
            </div>
            <div class="hidden sm:block w-px h-10 bg-slate-700"></div>
            <div class="max-w-md hidden sm:block">
                <p class="text-[10px] font-bold uppercase tracking-widest opacity-60 mb-1.5">Target Queue</p>
                <div id="selected-labels" class="flex flex-wrap gap-2 text-[10px] font-black uppercase tracking-widest text-indigo-400">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto">
            <button onclick="clearTaskSelection()" class="text-[10px] font-black text-slate-500 hover:text-red-400 uppercase tracking-widest transition-colors px-2 py-2">Clear Deck</button>
            <button id="batch-execute-btn" onclick="executeBatchCompletion()" class="bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs uppercase tracking-widest py-4 px-10 rounded-xl shadow-lg shadow-indigo-600/30 flex items-center gap-3 transition-all">
                <i class="fas fa-bolt"></i> Initiate Protocol
            </button>
        </div>
    </div>
</div>

<style>
    .asset-tile {
        aspect-ratio: 1 / 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .scrollbar-tactical::-webkit-scrollbar { width: 6px; display: block !important; }
    .scrollbar-tactical::-webkit-scrollbar-track { background: rgba(15,23,42,0.05); border-radius: 10px; }
    .scrollbar-tactical::-webkit-scrollbar-thumb { background: rgba(79,70,229,0.4); border-radius: 10px; }
    .scrollbar-tactical::-webkit-scrollbar-thumb:hover { background: rgba(79,70,229,0.8); }
</style>

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
        const tray = document.getElementById('execution-command-tray');
        const count = document.getElementById('execution-counter');
        const labels = document.getElementById('selected-labels');
 
        count.innerText = selectedAssets.length.toString().padStart(2, '0');
        
        if (selectedAssets.length > 0) {
            tray.classList.remove('translate-y-full');
            tray.classList.add('translate-y-0');
            labels.innerHTML = selectedAssets.map(a => `<span>${a.name}</span>`).join('<span class="opacity-30">•</span>');
        } else {
            tray.classList.add('translate-y-full');
            tray.classList.remove('translate-y-0');
        }
    }

    function clearTaskSelection() {
        selectedAssets.forEach(asset => {
            asset.el.className = asset.el.dataset.oldClasses || asset.el.dataset.idleClasses;
        });
        selectedAssets = [];
        updateTray();
        document.querySelectorAll('button[onclick*="bulkSelectFloorUnits"]').forEach(btn => {
            btn.innerText = "Select Floor Nodes";
        });
    }

    async function executeBatchCompletion() {
        if (selectedAssets.length === 0) return;
        const btn = document.getElementById('batch-execute-btn');
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i> SYNCING...`;

        const taskIds = selectedAssets.map(a => a.el.dataset.taskId).filter(id => id && id !== '');

        if (taskIds.length === 0) {
            alert('No assigned tasks selected.');
            btn.disabled = false;
            btn.innerHTML = originalContent;
            return;
        }

        try {
            const response = await fetch("{{ route('staff.tasks.complete.bulk') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ task_ids: taskIds })
            });

            if (response.ok) {
                selectedAssets.forEach(asset => {
                    asset.el.className = "asset-tile cursor-pointer relative rounded-2xl border-2 flex flex-col items-center justify-center gap-2 text-center transition-all bg-emerald-500 border-emerald-600 text-white shadow-lg scale-110 z-30";
                });
                btn.innerHTML = `<i class="fas fa-check-circle"></i> SUCCESS`;
                setTimeout(() => { window.location.reload(); }, 1500);
            } else {
                throw new Error('Sync failed');
            }
        } catch (e) {
            alert('SYNC FAILURE: Check connection.');
            btn.disabled = false;
            btn.innerHTML = originalContent;
        }
    }
</script>
@endsection
