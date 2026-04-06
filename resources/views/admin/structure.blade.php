@extends('layouts.app')

@section('title', 'Structure Configuration | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-8">
    
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 animate-fade-in-up">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">Facility Structure</h1>
            <p class="text-slate-600 dark:text-slate-400">Configure layout and manage hospital assets</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="openModal('modal-add-floor')" class="btn-secondary py-2.5 px-5 text-sm shadow-sm">
                <i class="fas fa-layer-group mr-2"></i> Add Floor
            </button>
            <button onclick="openModal('modal-generate-facility')" class="btn-primary py-2.5 px-5 text-sm shadow-sm">
                <i class="fas fa-magic mr-2"></i> Generate Facility
            </button>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-xl p-4">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-700 dark:text-red-400"><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    
    <div class="animate-fade-in-up" style="animation-delay:0.1s">
        <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-5 flex items-center gap-3">
            <i class="fas fa-layer-group text-primary-500"></i> Building Levels
        </h3>
        @if($floors->isEmpty())
            <div class="premium-card p-12 text-center text-slate-500 dark:text-slate-400">
                <i class="fas fa-building text-5xl mb-4 opacity-30 block"></i>
                <p class="font-bold uppercase tracking-widest text-sm mb-4">No floors configured yet.</p>
                <button onclick="openModal('modal-add-floor')" class="btn-primary py-2.5 px-6 text-sm">
                    <i class="fas fa-plus mr-2"></i> Add First Floor
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($floors as $floor)
                    <div class="premium-card p-6 border-t-4 border-t-primary-500 hover:-translate-y-1 transition-transform group">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-lg uppercase tracking-widest">Level {{ $floor->level == 0 ? 'G' : $floor->level }}</span>
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                                <button onclick="editFloor('{{ $floor->id }}', '{{ $floor->name }}', '{{ $floor->level }}')" class="w-8 h-8 rounded text-slate-400 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-500/10 flex items-center justify-center transition-colors">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <form action="{{ url('/admin/structure/floors/' . $floor->id) }}" method="POST" onsubmit="return confirm('Delete floor and all nested assets?')">
                                    @csrf @method('DELETE')
                                    <button class="w-8 h-8 rounded text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 flex items-center justify-center transition-colors">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <h4 class="text-xl font-extrabold text-slate-900 dark:text-white mb-4 uppercase tracking-tight">{{ $floor->name }}</h4>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                            <div class="bg-primary-50 dark:bg-primary-500/10 p-3 rounded-xl border border-primary-100 dark:border-primary-500/20 text-center">
                                <div class="text-xl font-black text-primary-600 dark:text-primary-400">{{ $floor->rooms->count() + $floor->washrooms->whereNull('room_id')->count() }}</div>
                                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-tight mt-1">Total Units</div>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-800/50 p-3 rounded-xl border border-slate-100 dark:border-slate-700 text-center">
                                <div class="text-xl font-black text-amber-600 dark:text-amber-400">{{ $floor->rooms->where('type','private')->count() }}</div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Private</div>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-800/50 p-3 rounded-xl border border-slate-100 dark:border-slate-700 text-center">
                                <div class="text-xl font-black text-blue-600 dark:text-blue-400">{{ $floor->rooms->where('type','general')->count() }}</div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">General</div>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-800/50 p-3 rounded-xl border border-slate-100 dark:border-slate-700 text-center">
                                <div class="text-xl font-black text-teal-600 dark:text-teal-400">{{ $floor->washrooms->whereNull('room_id')->count() }}</div>
                                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-tight mt-1">Standalone</div>
                            </div>
                        </div>

                        
                        <div class="max-h-0 overflow-hidden group-hover:max-h-[500px] transition-all duration-500 ease-in-out">
                            @php
                                $standaloneWr = $floor->washrooms->whereNull('room_id');
                            @endphp
                            @if($floor->rooms->count() > 0 || $standaloneWr->count() > 0)
                                <div class="mt-4 border-t border-slate-100 dark:border-slate-800 pt-4">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center justify-between">
                                        <span>Unit Blueprint Registry</span>
                                        <i class="fas fa-chevron-down text-[10px] animate-bounce"></i>
                                    </p>
                                    <div class="space-y-1.5 max-h-64 overflow-y-auto pr-1 custom-scrollbar">
                                        
                                        @foreach($floor->rooms->sortBy('room_number') as $room)
                                            <div class="flex items-center justify-between text-[11px] px-2.5 py-2 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 group/room hover:border-primary-500/30 transition-colors">
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $room->room_number }}</span>
                                                    @if($room->has_attached_washroom)
                                                        <i class="fas fa-link text-[10px] text-teal-500" title="Attached Washroom Sync"></i>
                                                    @endif
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <span class="font-bold {{ $room->type === 'private' ? 'text-amber-500' : 'text-blue-500' }} uppercase tracking-tighter text-[9px]">
                                                        {{ $room->type }}
                                                    </span>
                                                    <div class="flex gap-1.5 opacity-0 group-hover/room:opacity-100 transition-opacity">
                                                        <button onclick="editRoom('{{ $room->id }}', '{{ $room->room_number }}', '{{ $room->room_name }}', '{{ $room->type }}')" class="text-slate-400 hover:text-primary-500 transition-colors"><i class="fas fa-edit"></i></button>
                                                        <form action="{{ url('/admin/structure/rooms/' . $room->id) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="text-slate-400 hover:text-red-500 transition-colors"><i class="fas fa-trash-alt"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        
                                        @foreach($standaloneWr->sortBy('room_number') as $pw)
                                            <div class="flex items-center justify-between text-[11px] px-2.5 py-2 rounded-lg bg-teal-50/30 dark:bg-teal-900/10 border border-teal-100/50 dark:border-teal-900/30 group/pw hover:border-teal-500/30 transition-colors">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-restroom text-teal-600 dark:text-teal-400 text-[10px]"></i>
                                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $pw->room_number }}</span>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <span class="font-bold text-teal-600 dark:text-teal-400 uppercase tracking-tighter text-[9px]">
                                                        PUBLIC WR
                                                    </span>
                                                    <div class="flex gap-1.5 opacity-0 group-hover/pw:opacity-100 transition-opacity">
                                                        <button onclick="editWashroom('{{ $pw->id }}', '{{ $pw->room_number }}')" class="text-slate-400 hover:text-teal-500 transition-colors"><i class="fas fa-edit"></i></button>
                                                        <form action="{{ url('/admin/structure/washrooms/' . $pw->id) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="text-slate-400 hover:text-red-500 transition-colors"><i class="fas fa-trash-alt"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

<div id="modal-add-floor" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-add-floor')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 w-full max-w-md relative z-10 animate-zoom-in">
            <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-3">
                    <i class="fas fa-layer-group text-primary-500"></i> Add New Floor
                </h3>
                <button onclick="closeModal('modal-add-floor')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 w-8 h-8 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ url('/admin/structure/floors') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Floor Name</label>
                    <input type="text" name="name" required placeholder="e.g. Ground Floor, Floor 1..." class="input-premium py-2.5 px-4 text-sm w-full">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Level Number</label>
                    <input type="number" name="level" required placeholder="0, 1, 2..." class="input-premium py-2.5 px-4 text-sm w-full" min="0">
                </div>
                <button type="submit" class="w-full btn-primary py-3">Create Floor</button>
            </form>
        </div>
    </div>
</div>

<div id="modal-edit-floor" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-edit-floor')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 w-full max-w-md relative z-10 animate-zoom-in">
            <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Edit Floor</h3>
                <button onclick="closeModal('modal-edit-floor')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 w-8 h-8 rounded-lg flex items-center justify-center transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <form id="edit-floor-form" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Floor Name</label>
                    <input type="text" name="name" id="edit-floor-name" required class="input-premium py-2.5 px-4 text-sm w-full">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Level Number</label>
                    <input type="number" name="level" id="edit-floor-level" required class="input-premium py-2.5 px-4 text-sm w-full" min="0">
                </div>
                <button type="submit" class="w-full btn-primary py-3">Update Floor</button>
            </form>
        </div>
    </div>
</div>

<div id="modal-generate-facility" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-generate-facility')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 w-full max-w-md relative z-10 animate-zoom-in overflow-hidden max-h-[90vh] flex flex-col">
            <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-800/50 shrink-0">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-3">
                    <i class="fas fa-magic text-primary-500"></i> Generate Facility
                </h3>
                <button onclick="closeModal('modal-generate-facility')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 w-8 h-8 rounded-lg flex items-center justify-center transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ url('/admin/structure/rooms/generate') }}" method="POST" class="p-6 space-y-4 overflow-y-auto scrollbar-premium flex-1">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Select Floor</label>
                    <select name="floor_id" id="gen-floor-select" required class="input-premium py-2.5 px-4 text-sm w-full">
                        <option value="">Choose a floor...</option>
                        @foreach($floors as $floor)
                            <option value="{{ $floor->id }}" data-level="{{ $floor->level }}">Level {{ $floor->level == 0 ? 'G' : $floor->level }} — {{ $floor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Facility Template</label>
                    <select name="template_type" id="gen-template-type" required class="input-premium py-2.5 px-4 text-sm w-full">
                        <option value="private_attached">Private Room + Attached WR</option>
                        <option value="general_attached">General Ward + Attached WR</option>
                        <option value="public_washroom">Standalone Public Washroom</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Number of Units</label>
                    <input type="number" name="room_count" id="gen-room-count" required min="1" max="50" value="1" class="input-premium py-2.5 px-4 text-sm w-full">
                    <p class="text-[10px] text-slate-500">Use 1 for a single addition, or more for bulk generation.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1">Manual Number / Base ID <span class="font-normal text-slate-400 text-xs">(Optional)</span></label>
                    <input type="text" name="manual_number" id="gen-manual-number" placeholder="Leave blank for auto-numbering..." class="input-premium py-2.5 px-4 text-sm w-full">
                    <p class="text-[10px] text-slate-500">Auto format: Level + Sequence (e.g. 101, 102). Manual override will be used as the base.</p>
                </div>

                
                <div id="room-preview" class="hidden p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border-2 border-dashed border-slate-200 dark:border-slate-800 animate-fade-in">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Identity Deployment Preview</span>
                        <i class="fas fa-microchip text-primary-500 text-[10px]"></i>
                    </div>
                    <div id="preview-text" class="text-sm font-mono font-black text-primary-500 break-all bg-white dark:bg-slate-900 p-2 rounded-lg border border-slate-100 dark:border-slate-800 shadow-inner">
                        
                    </div>
                    <p class="text-[9px] text-slate-400 mt-2 italic"><i class="fas fa-info-circle mr-1"></i> These identifiers will be recorded in the persistent ledger.</p>
                </div>

                <button type="submit" class="w-full btn-primary py-3">Generate / Add Facility</button>
            </form>
        </div>
    </div>
</div>

<div id="modal-edit-room" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-edit-room')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 w-full max-w-md relative z-10 animate-zoom-in">
            <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Edit Room</h3>
                <button onclick="closeModal('modal-edit-room')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 w-8 h-8 rounded-lg flex items-center justify-center transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <form id="edit-room-form" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Room Number</label>
                    <input type="text" name="room_number" id="edit-room-number" required class="input-premium py-2.5 px-4 text-sm w-full">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Display Name</label>
                    <input type="text" name="room_name" id="edit-room-name" required class="input-premium py-2.5 px-4 text-sm w-full">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Room Type</label>
                    <select name="type" id="edit-room-type" class="input-premium py-2.5 px-4 text-sm w-full">
                        <option value="private">Private</option>
                        <option value="general">General</option>
                    </select>
                </div>
                <button type="submit" class="w-full btn-primary py-3">Update Room</button>
            </form>
        </div>
    </div>
</div>

<div id="modal-edit-washroom" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modal-edit-washroom')"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 w-full max-w-md relative z-10 animate-zoom-in">
            <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Edit Washroom Asset</h3>
                <button onclick="closeModal('modal-edit-washroom')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 w-8 h-8 rounded-lg flex items-center justify-center transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <form id="edit-washroom-form" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Asset Identifier / Number</label>
                    <input type="text" name="room_number" id="edit-washroom-number" required class="input-premium py-2.5 px-4 text-sm w-full">
                </div>
                <button type="submit" class="w-full btn-primary py-3">Update Asset</button>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(id) { 
    document.getElementById(id).classList.remove('hidden'); 
    if (id === 'modal-generate-facility') updatePreview(); 
}
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function editFloor(id, name, level) {
    document.getElementById('edit-floor-form').action = `/admin/structure/floors/${id}`;
    document.getElementById('edit-floor-name').value = name;
    document.getElementById('edit-floor-level').value = level;
    openModal('modal-edit-floor');
}

function editRoom(id, number, name, type) {
    document.getElementById('edit-room-form').action = `/admin/structure/rooms/${id}`;
    document.getElementById('edit-room-number').value = number;
    document.getElementById('edit-room-name').value = name;
    document.getElementById('edit-room-type').value = type;
    openModal('modal-edit-room');
}

function editWashroom(id, number) {
    document.getElementById('edit-washroom-form').action = `/admin/structure/washrooms/${id}`;
    document.getElementById('edit-washroom-number').value = number;
    openModal('modal-edit-washroom');
}

const floorLevels = @json($floors->mapWithKeys(fn($f) => [(string)$f->id => $f->level]));
const nextIndices = @json($nextIndices ?? []);

function updatePreview() {
    const floorId = document.getElementById('gen-floor-select').value;
    const count = parseInt(document.getElementById('gen-room-count').value) || 0;
    const template = document.getElementById('gen-template-type').value;
    const manual = document.getElementById('gen-manual-number').value.trim();
    const previewArea = document.getElementById('room-preview');
    const previewText = document.getElementById('preview-text');

    if (!floorId || count < 1) { previewArea.classList.add('hidden'); return; }

    const floorData = nextIndices[floorId] || { room: 1, washroom: 1 };
    const startIndex = template === 'public_washroom' ? floorData.washroom : floorData.room;
    
    const level = floorLevels[floorId] ?? 0;
    const roomPrefix = level === 0 ? 'G' : String(level);
    const pwPrefix   = level === 0 ? 'GPW' : 'PW' + String(level);
    const prefix     = template === 'public_washroom' ? pwPrefix : roomPrefix;

    const samples = [];
    
    for (let i = startIndex; i < startIndex + Math.min(count, 3); i++) {
        if (manual) {
            const offset = i - startIndex + 1;
            samples.push(count === 1 ? manual : manual + '-' + String(offset).padStart(2, '0'));
        } else {
            samples.push(prefix + String(i).padStart(2, '0'));
        }
    }
    if (count > 3) samples.push('...');
    
    previewText.textContent = samples.join(', ');
    previewArea.classList.remove('hidden');
}

document.getElementById('gen-floor-select').addEventListener('change', updatePreview);
document.getElementById('gen-template-type').addEventListener('change', updatePreview);
document.getElementById('gen-room-count').addEventListener('input', updatePreview);
document.getElementById('gen-manual-number').addEventListener('input', updatePreview);
</script>
@endsection
