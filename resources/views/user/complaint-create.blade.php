@extends('layouts.app')

@section('title', 'Log New Alert | WMS')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pt-6">
    
    <div class="mb-8 animate-fade-in-up">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-primary-500 uppercase tracking-widest mb-6 transition-colors group">
            <i class="fas fa-chevron-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Return to Portal
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2 tracking-tight">Log Incident Report</h1>
        <p class="text-slate-600 dark:text-slate-400">Initiate a formal tracking sequence for facility maintenance</p>
    </div>

    <div class="premium-card p-10 md:p-12 animate-fade-in-up bg-white/80 dark:bg-slate-900/60 backdrop-blur-3xl border-[3px] border-slate-200 dark:border-indigo-500/20 shadow-2xl shadow-slate-200/50 dark:shadow-none" style="animation-delay: 0.1s">
        
        <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf

            
            <div class="space-y-6">
                <div class="flex items-center gap-4 text-primary-500 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-500/10 flex items-center justify-center text-lg"><i class="fas fa-layer-group"></i></div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-widest">Phase 01</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Target Macro-level Structure</p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-black text-slate-700 dark:text-slate-300 mb-3 tracking-tighter uppercase">Facility Level</label>
                    <div class="relative group">
                        <select name="floor_id" id="comp-floor-id" required class="tactical-input py-5 pl-12 pr-10 text-base font-black w-full cursor-pointer appearance-none">
                            <option value="">SCANNING BUILDING LEVELS...</option>
                            @foreach($floors as $floor)
                                <option value="{{ $floor->id }}" data-rooms='{{ json_encode($floor->rooms) }}' data-washrooms='{{ json_encode($floor->washrooms) }}'>LEVEL {{ $floor->level }} - {{ $floor->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-hover:text-primary-500 transition-colors">
                            <i class="fas fa-building text-lg"></i>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
            </div>

            
            <div id="unit-selection-area" class="space-y-6 hidden animate-zoom-in">
                <div class="flex items-center gap-4 text-sky-500 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 dark:bg-sky-500/10 flex items-center justify-center text-lg"><i class="fas fa-crosshairs"></i></div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-widest">Phase 02</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Micro-level Coordinate Sync</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">Specific Room Node (Optional)</label>
                        <select name="room_id" id="comp-room-id" class="tactical-input py-4 px-5 w-full">
                            <option value="">Scanning attached vectors...</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">Sanitation Unit ID (Optional)</label>
                        <select name="washroom_id" id="comp-washroom-id" class="tactical-input py-4 px-5 w-full">
                            <option value="">Global facility scan...</option>
                        </select>
                    </div>
                </div>
            </div>

            
            <div class="space-y-6">
                <div class="flex items-center gap-4 text-amber-500 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-lg"><i class="fas fa-keyboard"></i></div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-widest">Phase 03</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Report Intelligence</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <div>
                        <label class="block text-sm font-black text-slate-700 dark:text-slate-300 mb-3 tracking-tighter uppercase">Incident Narrative</label>
                        <textarea name="message" required rows="7" 
                            class="tactical-input p-6 w-full text-sm leading-relaxed" 
                            placeholder="Detail the exact nature of the malfunction or hygiene critical incident..."></textarea>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-black text-slate-700 dark:text-slate-300 mb-3 tracking-tighter uppercase">Visual Verification Sync</label>
                        <div class="relative group h-[220px]">
                            <input type="file" name="image" id="complaint-image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30" onchange="previewImage(this)">
                            
                            <div id="image-dropzone" class="w-full h-full border-[3px] border-dashed border-slate-300 dark:border-slate-600 rounded-[2.5rem] flex flex-col items-center justify-center transition-all group-hover:border-indigo-500 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-500/10 bg-slate-50/80 dark:bg-slate-800/50 backdrop-blur-xl relative z-20 overflow-hidden">
                                
                                <div id="preview-placeholder" class="text-center group-hover:scale-105 transition-transform duration-300">
                                    <div class="w-12 h-12 rounded-full bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center mx-auto mb-3 text-slate-400 group-hover:text-primary-500 transition-colors">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <div class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest">Attach Media Asset</div>
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">JPG, PNG, WEBP (Max 5MB)</div>
                                </div>
                                
                                <img id="image-preview" class="hidden w-full h-full object-contain rounded-[2.5rem] absolute inset-0 z-10 p-2 bg-black/10 dark:bg-white/10 backdrop-blur-3xl">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="pt-8 border-t border-slate-100 dark:border-slate-800">
                <button type="submit" class="btn-primary w-full py-5 text-sm uppercase tracking-widest font-extrabold shadow-xl shadow-primary-500/20 group hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-satellite-dish mr-3 group-hover:animate-ping"></i> Dispatch Field Report
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const floorSelect = document.getElementById('comp-floor-id');
    const roomSelect = document.getElementById('comp-room-id');
    const washroomSelect = document.getElementById('comp-washroom-id');
    const unitArea = document.getElementById('unit-selection-area');

    floorSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (!option.value) {
            unitArea.classList.add('hidden');
            return;
        }

        unitArea.classList.remove('hidden');
        

        const rooms = JSON.parse(option.getAttribute('data-rooms') || '[]');
        const washrooms = JSON.parse(option.getAttribute('data-washrooms') || '[]');
        

        roomSelect.innerHTML = '<option value="">Any structural area...</option>';
        rooms.forEach(room => {
            roomSelect.innerHTML += `<option value="${room.id}">${room.room_name} (${room.type.toUpperCase()})</option>`;
        });

        washroomSelect.innerHTML = '<option value="">Any sanitation terminal...</option>';
        washrooms.forEach(wr => {
            const label = wr.room_id ? 'ATTACHED_UNIT' : (wr.room_number || 'STRUCTURAL_ASSET');
            const prefix = wr.room_id ? '[ATTACHED]' : '[PUBLIC]';
            washroomSelect.innerHTML += `<option value="${wr.id}">${prefix} ${label}</option>`;
        });
    });

    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('preview-placeholder');
        const dropzone = document.getElementById('image-dropzone');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                dropzone.classList.add('border-primary-500');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

