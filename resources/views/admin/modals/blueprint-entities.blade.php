
<div id="modal-floor" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-3xl transition-all duration-500">
    <div class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-3xl rounded-[3rem] p-12 max-w-md w-full shadow-[0_0_80px_rgba(0,0,0,0.3)] dark:shadow-[0_0_80px_rgba(79,70,229,0.2)] border-[3px] border-slate-200 dark:border-indigo-500/30 relative animate-zoom-in">
        <button onclick="document.getElementById('modal-floor').classList.add('hidden')" class="absolute top-8 right-8 text-slate-300 hover:text-slate-600 transition-colors"><i class="fas fa-times text-2xl"></i></button>
        <h3 class="text-3xl font-black text-slate-950 mb-8 flex items-center italic uppercase tracking-tighter text-halo-obsidian"><i class="fas fa-layer-group text-indigo-600 mr-4"></i> New Floor</h3>
        <form action="{{ route('admin.floors.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[12px] font-black text-slate-950 dark:text-white uppercase tracking-widest mb-3 ml-1">Structural Handle</label>
                <input type="text" name="name" required class="tactical-input w-full border-slate-300 dark:border-indigo-500/20" placeholder="e.g. Surgical Wing A">
            </div>
            <div>
                <label class="block text-[12px] font-black text-slate-950 dark:text-white uppercase tracking-widest mb-3 ml-1">Vertical Level Index</label>
                <input type="number" name="level" required class="tactical-input w-full border-slate-300 dark:border-indigo-500/20" placeholder="0">
            </div>
            <button type="submit" class="w-full py-5 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:-translate-y-1 transition-all uppercase tracking-[0.2em] text-xs">Initialize level</button>
        </form>
    </div>
</div>

<div id="modal-structure" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-3xl transition-all duration-500">
    <div class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-3xl rounded-[3rem] p-12 max-w-lg w-full shadow-[0_0_80px_rgba(0,0,0,0.3)] dark:shadow-[0_0_80px_rgba(79,70,229,0.2)] border-[3px] border-slate-200 dark:border-indigo-500/30 relative animate-zoom-in">
        <button onclick="document.getElementById('modal-structure').classList.add('hidden')" class="absolute top-8 right-8 text-slate-300 hover:text-slate-600 transition-colors"><i class="fas fa-times text-2xl"></i></button>
        <h3 class="text-3xl font-black text-slate-950 mb-8 flex items-center italic uppercase tracking-tighter text-halo-obsidian"><i class="fas fa-cubes text-indigo-600 mr-4"></i> New Structure</h3>
        <form action="{{ route('admin.structure.store') }}" method="POST" class="space-y-6">
            @csrf
            
            
            <div>
                <label class="block text-[12px] font-black text-slate-950 dark:text-white uppercase tracking-widest mb-3">Host Floor</label>
                <select name="floor_id" required class="tactical-input w-full border-slate-300 dark:border-indigo-500/20">
                    <option value="">Select Floor...</option>
                    @foreach($floors as $floor) <option value="{{ $floor->_id }}">{{ $floor->name }}</option> @endforeach
                </select>
            </div>

            
            <div>
                <label class="block text-[12px] font-black text-slate-950 dark:text-white uppercase tracking-widest mb-3">Washroom Type</label>
                <select name="washroom_type" id="structure_washroom_type" required class="tactical-input w-full border-slate-300 dark:border-indigo-500/20" onchange="toggleStructureRoomFields()">
                    <option value="attached" selected>Attached</option>
                    <option value="public">Public</option>
                </select>
            </div>

            
            <div id="logistics_section" class="space-y-6 bg-slate-50 dark:bg-slate-950/50 p-8 rounded-[2.5rem] border-[3px] border-slate-200 dark:border-indigo-500/10 backdrop-blur-xl">
                <div>
                    <label class="block text-[11px] font-black text-slate-800 dark:text-slate-300 uppercase tracking-widest mb-3">Room No / Asset ID</label>
                    <input type="text" name="room_number" id="structure_room_number" required class="tactical-input w-full border-slate-300 dark:border-indigo-500/20" placeholder="Ex: G-101 or P-04">
                </div>

                <div id="structure_room_details" class="space-y-6 pt-6 border-t-[3px] border-slate-200 dark:border-slate-800">
                    <div>
                        <label class="block text-[11px] font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest mb-3">Room Type</label>
                        <select name="room_type" id="structure_room_type" class="tactical-input w-full border-slate-300 dark:border-indigo-500/20">
                            <option value="private">Private</option>
                            <option value="general" selected>General</option>
                        </select>
                    </div>
                    <input type="hidden" name="room_name" id="structure_room_name">
                </div>
            </div>

            <button type="submit" class="w-full py-5 bg-indigo-900 text-white font-black rounded-2xl shadow-xl hover:-translate-y-1 transition-all uppercase tracking-[0.2em] text-xs">Establish Structure</button>
        </form>
    </div>
</div>

<script>
function toggleStructureRoomFields() {
    const type = document.getElementById('structure_washroom_type').value;
    const roomDetails = document.getElementById('structure_room_details');
    const roomType = document.getElementById('structure_room_type');

    if (type === 'attached') {
        roomDetails.classList.remove('hidden');
        roomType.required = true;
    } else {
        roomDetails.classList.add('hidden');
        roomType.required = false;
    }
}

document.getElementById('structure_room_number').addEventListener('input', function() {
    document.getElementById('structure_room_name').value = this.value;
});

document.addEventListener('DOMContentLoaded', toggleStructureRoomFields);
</script>

