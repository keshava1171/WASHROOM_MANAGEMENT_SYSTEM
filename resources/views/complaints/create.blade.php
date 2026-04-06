@extends('layouts.app')

@section('title', 'Report Issue | WMS')

@section('content')
<div class="max-w-3xl mx-auto pb-24">
    
    <div class="flex items-center justify-between mb-8 animate-fade-in-up">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
                <i class="fas fa-chevron-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Report Issue</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Tactical failure reporting uplink.</p>
            </div>
        </div>
        <div class="hidden sm:block">
            <span class="px-3 py-1 rounded-full bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 text-[10px] font-black uppercase tracking-widest">
                Priority Alpha
            </span>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20">
            <ul class="list-disc list-inside text-sm text-rose-600 dark:text-rose-400 font-bold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        
        <div class="premium-card p-6 md:p-8 space-y-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-500 text-white flex items-center justify-center text-xs shadow-lg shadow-indigo-500/20">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest">Location Data</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="space-y-2">
                    <label for="floor_id" class="block text-xs font-black text-slate-500 uppercase tracking-widest">Floor Level <span class="text-rose-500">*</span></label>
                    <select name="floor_id" id="floor_id" required onchange="updateSelectors()" class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm font-bold text-slate-900 dark:text-white focus:border-indigo-500 transition-all outline-none appearance-none">
                        <option value="">-- SELECT FLOOR --</option>
                        @foreach($floors as $floor)
                            <option value="{{ $floor->id }}" data-rooms='@json($floor->rooms)' data-washrooms='@json($floor->washrooms)'>
                                {{ $floor->name }} (Level {{ $floor->level }})
                            </option>
                        @endforeach
                    </select>
                </div>

                
                <div class="space-y-2">
                    <label for="unit_selector" class="block text-xs font-black text-slate-500 uppercase tracking-widest">Identified Unit <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select id="unit_selector" onchange="handleUnitSelection()" required class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm font-bold text-slate-900 dark:text-white focus:border-indigo-500 transition-all outline-none appearance-none">
                            <option value="">-- SELECT UNIT --</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    <input type="hidden" name="room_id" id="room_id">
                    <input type="hidden" name="washroom_id" id="washroom_id">
                </div>
            </div>
        </div>

        
        <div class="premium-card p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center text-xs shadow-lg shadow-rose-500/20">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest">Failure Classification</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="type-grid">
                @php
                    $types = [
                        'No Soap Available',
                        'Not Clean / Dirty Washroom',
                        'Water Leakage',
                        'Bad Smell',
                        'Broken Fixtures',
                        'No Water Supply',
                        'Staff Misbehavior',
                        'Cleaning Not Done',
                        'Other'
                    ];
                @endphp
                @foreach($types as $type)
                    <div onclick="selectType(this, '{{ $type }}')" class="complaint-type-card cursor-pointer p-4 rounded-2xl border-2 border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex items-center justify-between group hover:border-indigo-500 transition-all">
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300 group-hover:text-indigo-500">{{ $type }}</span>
                        <div class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-700 flex items-center justify-center group-hover:border-indigo-500 transition-all">
                            <div class="w-2.5 h-2.5 rounded-full bg-indigo-500 scale-0 transition-transform duration-300"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="complaint_type" id="complaint_type_val" required>

            
            <div id="description-area" class="mt-8 space-y-2 opacity-0 h-0 overflow-hidden transition-all duration-500">
                <label for="description" class="block text-xs font-black text-slate-500 uppercase tracking-widest">Operational Intelligence <span id="desc-required" class="text-rose-500 hidden text-[8px]">(REQUIRED FOR 'OTHER')</span></label>
                <textarea name="description" id="description" placeholder="Provide detailed tactical overview of the failure..." class="w-full bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-800 rounded-2xl px-4 py-4 text-sm font-bold text-slate-900 dark:text-white focus:border-indigo-500 transition-all outline-none resize-none min-h-[120px]"></textarea>
            </div>
        </div>

        
        <div class="premium-card p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs shadow-lg shadow-amber-500/20">
                    <i class="fas fa-camera"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest">Visual Evidence</h3>
            </div>

            <div class="relative group">
                <input type="file" name="image" id="image" accept="image/*" capture="environment" onchange="previewImage(this)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                <div id="image-placeholder" class="w-full h-48 border-4 border-dashed border-slate-200 dark:border-slate-800 rounded-3xl flex flex-col items-center justify-center gap-3 group-hover:border-indigo-500/50 transition-all bg-slate-50/50 dark:bg-slate-900/50">
                    <div class="w-16 h-16 rounded-2xl bg-white dark:bg-slate-800 text-slate-400 group-hover:text-amber-500 flex items-center justify-center text-2xl shadow-sm transition-all group-hover:scale-110">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-black text-slate-700 dark:text-slate-300">Capture Proof</p>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">PNG, JPG to 10MB</p>
                    </div>
                </div>
                <div id="image-preview" class="hidden w-40 h-40 mx-auto rounded-3xl border-2 border-indigo-500 overflow-hidden relative shadow-2xl animate-fade-in-up">
                    <img id="preview-img" src="#" alt="Tactical Evidence" class="w-full h-full object-cover">
                    <button type="button" onclick="resetImage()" class="absolute top-2 right-2 w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center shadow-lg hover:bg-rose-600 transition-all z-30">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                    <div class="absolute bottom-0 left-0 right-0 p-1.5 bg-indigo-600/90 backdrop-blur-md text-center">
                        <p class="text-[8px] font-black text-white uppercase tracking-widest leading-none">Evidence Synced</p>
                    </div>
                </div>
            </div>
        </div>

        
        <button type="submit" class="w-full btn-primary bg-indigo-600 hover:bg-indigo-700 py-6 rounded-2xl shadow-[0_20px_50px_rgba(79,70,229,0.3)] group relative overflow-hidden transition-all active:scale-[0.98]">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-violet-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <span class="relative z-10 flex items-center justify-center gap-3 text-lg font-black uppercase tracking-[0.2em]">
                <i class="fas fa-satellite-dish animate-pulse"></i> Submit Tactical Failure Report
            </span>
        </button>
    </form>
</div>

<script>
    function selectType(el, type) {
        document.querySelectorAll('.complaint-type-card').forEach(card => {
            card.classList.remove('border-indigo-500', 'bg-indigo-50/50', 'dark:bg-indigo-500/10');
            card.querySelector('div div').classList.add('scale-0');
        });
        
        el.classList.add('border-indigo-500', 'bg-indigo-50/50', 'dark:bg-indigo-500/10');
        el.querySelector('div div').classList.remove('scale-0');
        
        document.getElementById('complaint_type_val').value = type;

        const descArea = document.getElementById('description-area');
        const descRequired = document.getElementById('desc-required');
        
        descArea.classList.remove('opacity-0', 'h-0', 'overflow-hidden');
        descArea.classList.add('h-auto', 'mt-8');

        if (type === 'Other') {
            descRequired.classList.remove('hidden');
            document.getElementById('description').setAttribute('required', 'required');
        } else {
            descRequired.classList.add('hidden');
            document.getElementById('description').removeAttribute('required');
        }
    }

    function id_safe(obj) {
        if (!obj) return null;
        const raw = obj.id ?? null;
        if (!raw) return null;
        if (typeof raw === 'string') return raw;
        if (typeof raw === 'object' && raw.$oid) return raw.$oid;
        return String(raw);
    }

    function updateSelectors() {
        const floorSelect   = document.getElementById('floor_id');
        const unitSelector  = document.getElementById('unit_selector');
        const roomInput     = document.getElementById('room_id');
        const washroomInput = document.getElementById('washroom_id');

        unitSelector.innerHTML = '<option value="">-- SELECT UNIT --</option>';
        roomInput.value     = "";
        washroomInput.value = "";

        if (!floorSelect.value) return;

        const selectedOption = floorSelect.options[floorSelect.selectedIndex];

        let rooms = [];
        let allWashrooms = [];
        try { rooms        = JSON.parse(selectedOption.dataset.rooms      || '[]'); } catch(e) {}
        try { allWashrooms = JSON.parse(selectedOption.dataset.washrooms  || '[]'); } catch(e) {}

        const standaloneWashrooms = allWashrooms.filter(w => !w.room_id);

        if (rooms.length > 0) {
            const grp = document.createElement('optgroup');
            grp.label = "── HOSPITAL ROOMS ──";
            rooms.forEach(r => {
                const id = id_safe(r);
                if (!id) return;
                const opt = new Option(
                    `Room ${r.room_number || 'N/A'}  (${(r.type || 'Standard').toUpperCase()})`,
                    `room|${id}`
                );
                grp.appendChild(opt);
            });
            unitSelector.appendChild(grp);
        }

        if (standaloneWashrooms.length > 0) {
            const grp = document.createElement('optgroup');
            grp.label = "── PUBLIC WASHROOMS ──";
            standaloneWashrooms.forEach(w => {
                const id = id_safe(w);
                if (!id) return;
                const opt = new Option(
                    `Washroom ${w.room_number || w.name || 'N/A'}`,
                    `washroom|${id}`
                );
                grp.appendChild(opt);
            });
            unitSelector.appendChild(grp);
        }

        unitSelector.appendChild(new Option("GENERAL FLOOR AREA", "general|null"));
    }

    function handleUnitSelection() {
        const unitSelector  = document.getElementById('unit_selector');
        const roomInput     = document.getElementById('room_id');
        const washroomInput = document.getElementById('washroom_id');

        roomInput.value     = "";
        washroomInput.value = "";

        if (!unitSelector.value) return;

        const [type, id] = unitSelector.value.split('|');
        const safeId     = (id && id !== 'null') ? id : "";

        if (type === 'room') {
            roomInput.value = safeId;
        } else if (type === 'washroom') {
            washroomInput.value = safeId;
        }

    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-placeholder').classList.add('hidden');
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('preview-img').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetImage() {
        const input = document.getElementById('image');
        input.value = "";
        document.getElementById('image-placeholder').classList.remove('hidden');
        document.getElementById('image-preview').classList.add('hidden');
    }
</script>

<style>
    .premium-card {
        @apply bg-white/70 dark:bg-slate-800/50 backdrop-blur-xl rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-xl;
    }
    .complaint-type-card:hover {
        @apply transform scale-[1.02];
    }
</style>
@endsection

