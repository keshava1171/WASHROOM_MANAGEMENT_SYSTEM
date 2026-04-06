
<div id="modal-edit-floor" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
    <div class="bg-white rounded-[3rem] p-10 max-w-md w-full shadow-2xl relative animate-zoom-in">
        <button onclick="document.getElementById('modal-edit-floor').classList.add('hidden')" class="absolute top-8 right-8 text-slate-300 hover:text-slate-600 transition-colors"><i class="fas fa-times text-2xl"></i></button>
        <h3 class="text-3xl font-black text-slate-800 mb-8 flex items-center italic uppercase tracking-tighter"><i class="fas fa-pen text-indigo-500 mr-4"></i> Edit Level</h3>
        <form id="edit-floor-form" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Update Descriptor</label>
                <input type="text" id="edit_floor_name" name="name" required class="w-full px-5 py-4 bg-slate-50 border border-slate-300 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-bold text-slate-900" placeholder="e.g. Ground Floor">
            </div>
            <div>
                <label class="block text-xs font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Update Vertical Index</label>
                <input type="number" id="edit_floor_level" name="level" required class="w-full px-5 py-4 bg-slate-50 border border-slate-300 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-bold text-slate-900" placeholder="0">
            </div>
            <button type="submit" class="w-full py-5 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:-translate-y-1 transition-all uppercase tracking-[0.2em] text-xs">Commit Updates</button>
        </form>
    </div>
</div>

<div id="modal-edit-washroom" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
    <div class="bg-white rounded-[3rem] p-10 max-w-md w-full shadow-2xl relative animate-zoom-in">
        <button onclick="document.getElementById('modal-edit-washroom').classList.add('hidden')" class="absolute top-8 right-8 text-slate-300 hover:text-slate-600 transition-colors"><i class="fas fa-times text-2xl"></i></button>
        <h3 class="text-3xl font-black text-slate-800 mb-8 flex items-center italic uppercase tracking-tighter"><i class="fas fa-pen text-amber-500 mr-4"></i> Edit Asset</h3>
        <form id="edit-washroom-form" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Room No / Asset ID</label>
                <input type="text" id="edit_washroom_room_number" name="room_number" required class="w-full px-5 py-4 bg-slate-50 border border-slate-300 rounded-2xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 outline-none font-bold text-slate-900" placeholder="e.g. PW-GF-01">
            </div>
            <button type="submit" class="w-full py-5 bg-amber-600 text-white font-black rounded-2xl shadow-xl hover:-translate-y-1 transition-all uppercase tracking-[0.2em] text-xs">Verify & Update</button>
        </form>
    </div>
</div>

<div id="modal-edit-room" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
    <div class="bg-white rounded-[3rem] p-10 max-w-md w-full shadow-2xl relative animate-zoom-in">
        <button onclick="document.getElementById('modal-edit-room').classList.add('hidden')" class="absolute top-8 right-8 text-slate-300 hover:text-slate-600 transition-colors"><i class="fas fa-times text-2xl"></i></button>
        <h3 class="text-3xl font-black text-slate-800 mb-8 flex items-center italic uppercase tracking-tighter"><i class="fas fa-pen text-sky-500 mr-4"></i> Edit Space</h3>
        <form id="edit-room-form" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Space Descriptor</label>
                <input type="text" id="edit_room_name" name="room_name" required class="w-full px-5 py-4 bg-slate-50 border border-slate-300 rounded-2xl focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none font-bold text-slate-900" placeholder="e.g. ICU-01">
            </div>
            <div>
                <label class="block text-xs font-black text-slate-800 uppercase tracking-widest mb-3 ml-1">Classification Select</label>
                <select name="type" id="edit_room_type" required class="w-full px-5 py-4 bg-slate-50 border border-slate-300 rounded-2xl focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none font-bold text-slate-900 text-sm">
                    <option value="private">Private (Dedicated access)</option>
                    <option value="general">General (Shared environment)</option>
                </select>
            </div>
            <button type="submit" class="w-full py-5 bg-sky-900 text-white font-black rounded-2xl shadow-xl hover:-translate-y-1 transition-all uppercase tracking-[0.2em] text-xs">Update Architecture</button>
        </form>
    </div>
</div>

