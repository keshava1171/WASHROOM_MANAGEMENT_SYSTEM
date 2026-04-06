@extends('layouts.app')

@section('title', 'Onboard Operational Staff | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 animate-fade-in-up">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors border border-transparent dark:border-slate-700">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-1 tracking-tight">Onboard Operational Staff</h1>
                <p class="text-slate-600 dark:text-slate-400">Generate credentials for new protocol operatives</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start animate-fade-in-up" style="animation-delay: 0.1s">
        
        <div class="premium-card p-8">
            <form action="{{ route('admin.store-staff') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Operative Designation (Name)</label>
                        <div class="input-group-tactical">
                            <div class="icon-box-tactical">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. John Operator" 
                                   class="tactical-input w-full">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 text-primary-500">Comms Uplink (Email Address)</label>
                        <div class="input-group-tactical">
                            <div class="icon-box-tactical">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@hospital.org" 
                                   class="tactical-input w-full">
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-sky-50 dark:bg-sky-500/10 rounded-xl border border-sky-100 dark:border-sky-500/20 shadow-sm text-sm">
                    <p class="font-bold text-sky-800 dark:text-sky-300 mb-2 flex items-center">
                        <i class="fas fa-shield-alt mr-2 text-sky-500"></i> Auto-Generated Security Protocol
                    </p>
                    <p class="text-sky-700 dark:text-sky-400 text-xs">
                        The system will automatically generate a secure 256-bit entropy password and email it directly to the operative along with login instructions. They will be mandated to change it upon initial authentication.
                    </p>
                </div>

                <button type="submit" class="w-full btn-primary py-4 text-sm uppercase tracking-widest font-bold group shadow-lg shadow-primary-500/30">
                    <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform"></i>
                    Initialize Operative Credentials
                </button>
            </form>
        </div>

        
        <div class="space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 rounded-2xl p-6 shadow-sm animate-zoom-in">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-4 text-xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="font-bold text-emerald-800 dark:text-emerald-300 mb-2 text-lg">System Success</h3>
                    <p class="text-emerald-700/80 dark:text-emerald-400/80 text-sm mb-4">{{ session('success') }}</p>
                    
                    @if(session('staff_creds'))
                        <div class="bg-white dark:bg-slate-900 border border-red-200 dark:border-red-500/30 p-4 rounded-xl relative shadow-inner">
                            <div class="absolute -top-3 left-4 bg-red-50 dark:bg-red-500/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/30 px-3 py-0.5 rounded-lg text-xs font-bold uppercase tracking-widest animate-pulse">
                                SMTP FAILURE - MANUAL SHARE REQUIRED
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest font-bold mb-1 mt-2">Designation</p>
                            <p class="text-slate-900 dark:text-white font-mono text-sm mb-3">{{ session('staff_creds')['name'] }}</p>
                            
                            <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest font-bold mb-1">Uplink</p>
                            <p class="text-slate-900 dark:text-white font-mono text-sm mb-3">{{ session('staff_creds')['email'] }}</p>
                            
                            <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest font-bold mb-1">Initial Key</p>
                            <p class="text-red-600 dark:text-red-400 font-mono text-lg font-bold tracking-widest p-2 bg-red-50 dark:bg-red-500/10 rounded border border-red-200 dark:border-red-500/20">{{ session('staff_creds')['password'] }}</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="premium-card p-8 border-l-4 border-l-secondary-500 bg-slate-50/50 dark:bg-slate-800/20 text-center flex flex-col items-center justify-center">
                    <i class="fas fa-id-badge text-6xl text-slate-200 dark:text-slate-700 mb-6 drop-shadow-sm"></i>
                    <h3 class="font-bold text-slate-700 dark:text-slate-300 mb-2">Staff Capabilities</h3>
                    <ul class="text-sm text-slate-500 dark:text-slate-400 text-left space-y-2 inline-block">
                        <li class="flex items-center"><i class="fas fa-check text-emerald-500 mr-2"></i> Receive assigned operation tasks</li>
                        <li class="flex items-center"><i class="fas fa-check text-emerald-500 mr-2"></i> Update operational statuses</li>
                        <li class="flex items-center"><i class="fas fa-check text-emerald-500 mr-2"></i> Generate physical print manifests</li>
                        <li class="flex items-center"><i class="fas fa-check text-emerald-500 mr-2"></i> View restricted intelligence queue</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

