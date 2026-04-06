@extends('layouts.app')

@section('title', 'Issue Radar | Staff | WMS')

@section('sidebar')
    @include('staff.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 animate-fade-in-up">
        <div class="flex items-center gap-6">
            <a href="{{ route('staff.dashboard') }}" class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-lg group">
                <i class="fas fa-chevron-left group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-1 tracking-tight">Issue Radar</h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Identify and resolve active zone infractions</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2">
                <input type="checkbox" id="select-all-complaints" class="w-5 h-5 rounded border-2 border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 bg-transparent">
                <label for="select-all-complaints" class="text-[10px] font-black uppercase tracking-widest text-slate-400">Select All</label>
            </div>
        </div>

    </div>

    
    <div class="premium-card p-4 animate-fade-in-up" style="animation-delay: 0.05s">
        <form action="{{ route('staff.complaints') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-4 items-center">
            <div class="relative flex-1 min-w-[200px]">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Reporter, Description..." 
                       class="input-premium pl-11 py-2 text-sm w-full">
            </div>
            
            <select name="status" class="input-premium py-2 px-6 text-sm w-full md:w-48 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-800 rounded-xl font-bold">
                <option value="">All Active Issues</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Completed</option>
            </select>
            
            <button type="submit" class="btn-primary py-2 px-8 shadow-sm text-xs whitespace-nowrap font-black uppercase tracking-widest">
                <i class="fas fa-filter mr-2"></i> Scan
            </button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('staff.complaints') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-rose-500 transition-colors">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 animate-fade-in-up max-h-[75vh] overflow-y-auto custom-scrollbar pr-2 pb-4" style="animation-delay: 0.1s">
        @forelse($complaints as $complaint)
            <div class="premium-card flex flex-col h-full border-t-8 {{ $complaint->status == 'pending' ? 'border-t-amber-500' : ($complaint->status == 'in_progress' ? 'border-t-indigo-500' : 'border-t-emerald-500') }} shadow-2xl bg-white/80 dark:bg-slate-900/60 backdrop-blur-3xl">
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="complaint_ids[]" value="{{ (string)$complaint->_id }}" class="complaint-checkbox w-5 h-5 rounded border-2 border-slate-300 dark:border-slate-700 text-indigo-600 focus:ring-indigo-500 bg-white dark:bg-slate-900 transition-all cursor-pointer">
                            <span class="status-badge {{ $complaint->status }}">
                                @if($complaint->status == 'pending') <i class="fas fa-clock mr-1"></i>
                                @elseif($complaint->status == 'in_progress') <i class="fas fa-tools mr-1"></i>
                                @else <i class="fas fa-check-double mr-1"></i> @endif
                                {{ str_replace('_', ' ', $complaint->status) }}
                            </span>
                        </div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">
                            {{ $complaint->created_at->diffForHumans() }}
                        </div>
                    </div>
 
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-1 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-[10px] font-black uppercase tracking-widest">
                            {{ $complaint->complaint_type }}
                        </span>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2 truncate">
                            <i class="fas fa-map-marker-alt text-primary-500"></i>
                            {{ $complaint->getLocationDisplay() }}
                        </h3>
                    </div>

                    <div class="flex flex-col gap-4 flex-1">
                        @if($complaint->image_path)
                            <div class="space-y-1.5">
                                <p class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">Proof</p>
                                <div class="w-full h-32 rounded-2xl border-2 border-slate-200 dark:border-slate-800 overflow-hidden cursor-pointer group/img relative" onclick="openLightbox('{{ asset('storage/' . $complaint->image_path) }}')">
                                    <img src="{{ asset('storage/' . $complaint->image_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-110">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/img:opacity-100 flex items-center justify-center transition-opacity">
                                        <i class="fas fa-expand text-white text-xs"></i>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $complaint->image_path) }}" download class="flex items-center justify-center gap-2 py-1 text-[9px] font-black uppercase tracking-widest text-indigo-500 hover:text-indigo-600 transition-colors">
                                    <i class="fas fa-download"></i> Download Proof
                                </a>
                            </div>
                        @endif
                        
                        <div class="space-y-1.5 flex-1">
                            <p class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">Description</p>
                            <div class="bg-white/50 dark:bg-slate-800/40 backdrop-blur-xl rounded-2xl p-4 flex-1 border-[3px] border-slate-200 dark:border-slate-800">
                                <p class="text-slate-700 dark:text-slate-300 text-xs leading-relaxed font-black italic">
                                    "{{ $complaint->description ?: 'No additional tactical intel provided.' }}"
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($complaint->admin_notes && $complaint->status !== 'resolved')
                        <div class="mt-4 p-3 bg-red-50 dark:bg-red-500/10 rounded-xl border border-red-200 dark:border-red-500/30">
                            <p class="text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-widest mb-1"><i class="fas fa-exclamation-triangle mr-1"></i> Command Directive</p>
                            <p class="text-xs text-red-800 dark:text-red-300 font-medium">{{ $complaint->admin_notes }}</p>
                        </div>
                    @endif
                </div>

                
                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-200 dark:border-slate-800">
                    <form action="{{ route('staff.complaints.resolve', $complaint) }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="flex-1 space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest pl-1">Resolution & Feedback</label>
                                <textarea name="notes" rows="2" placeholder="Detail action taken..." 
                                          class="input-premium py-2 text-xs w-full bg-white dark:bg-slate-800 shadow-inner"
                                          {{ $complaint->status == 'resolved' ? 'disabled' : '' }}>{{ $complaint->admin_notes }}</textarea>
                            </div>
                            <div class="w-full md:w-48 space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest pl-1">Current Protocol</label>
                                <select name="status" class="input-premium py-2 text-xs w-full bg-white dark:bg-slate-800"
                                        {{ $complaint->status == 'resolved' ? 'disabled' : '' }}>
                                    <option value="in_progress" {{ $complaint->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Resolved (Close)</option>
                                </select>
                            </div>
                        </div>

                        @if($complaint->status !== 'resolved')
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[9px] font-bold text-slate-400 italic">
                                    @if($complaint->last_updated_by)
                                        <i class="fas fa-history mr-1"></i> Last sync by {{ $complaint->last_updated_by }}
                                    @endif
                                </span>
                                <button type="submit" class="btn-primary py-2 px-6 shadow-sm text-[10px] font-black uppercase tracking-widest">
                                    <i class="fas fa-sync-alt mr-2"></i> Update Node
                                </button>
                            </div>
                        @else
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-[9px] font-bold text-emerald-500/70 italic uppercase tracking-widest">
                                    <i class="fas fa-check-circle mr-1"></i> Closed Out by {{ $complaint->last_updated_by ?? 'Personnel' }}
                                </span>
                                <a href="{{ route('complaints.print', $complaint->id) }}" target="_blank" class="px-4 py-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[9px] font-black uppercase tracking-widest border border-emerald-200 dark:border-emerald-500/20">
                                    <i class="fas fa-print mr-1"></i> Print Paper
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

        @empty
            <div class="col-span-full premium-card p-16 text-center text-slate-500 border-[3px] border-dashed border-slate-300 dark:border-slate-700 bg-slate-50/20 dark:bg-slate-800/10 backdrop-blur-3xl rounded-[3rem]">
                <div class="w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-800 mx-auto flex items-center justify-center mb-6 text-slate-300 dark:text-slate-600 border-[3px] border-slate-200 dark:border-slate-700">
                    <i class="fas fa-thumbs-up text-4xl"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2 uppercase tracking-tighter">Sector Clear</h3>
                <p class="text-sm font-bold uppercase tracking-widest text-slate-500">No active incidents detected in the operational zone.</p>
            </div>
        @endforelse
    </div>
</div>

<div id="lightbox" class="fixed inset-0 z-[100] bg-slate-950/90 backdrop-blur-xl hidden flex flex-col items-center justify-center p-4" onclick="closeLightbox()">
    <button class="absolute top-8 right-8 text-white/50 hover:text-white text-4xl transition-colors">
        <i class="fas fa-times"></i>
    </button>
    <img id="lightbox-img" src="" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl border border-white/10 object-contain">
    <div class="mt-8 px-6 py-3 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 text-white font-black uppercase tracking-widest text-xs">
        Tactical Evidence Log
    </div>
</div>

<script>
    function openLightbox(src) {
        const lightbox = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        img.src = src;
        lightbox.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
 
    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
 

    document.getElementById('select-all-complaints').addEventListener('change', function() {
        document.querySelectorAll('.complaint-checkbox').forEach(cb => cb.checked = this.checked);
    });
 
    async function executeBulkAction(action) {
        const selected = Array.from(document.querySelectorAll('.complaint-checkbox:checked')).map(cb => cb.value);
        
        if (selected.length === 0) {
            alert('No tactical infractions selected for protocol execution.');
            return;
        }
 
        if (!confirm(`Initiate mass protocol update [Type: ${action.toUpperCase()}] for ${selected.length} nodes?`)) return;
 
        try {
            const response = await fetch("{{ route('staff.complaints.bulk') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    complaint_ids: selected,
                    action: action
                })
            });
            
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Command execution failure. Tactical sync interrupted.');
            }
        } catch (e) {
            alert('Signal loss. Check network downlink.');
        }
    }
</script>
@endsection

