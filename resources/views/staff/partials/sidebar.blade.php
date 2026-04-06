<div class="h-full flex flex-col justify-between">
    <div>
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-6 px-2">
                <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold shadow-inner">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ auth()->user()->name }}</h3>
                    <p class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-500">Operative</p>
                </div>
            </div>

            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Operations</h3>
            <nav class="space-y-1">
                <a href="{{ route('staff.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group {{ request()->routeIs('staff.dashboard') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('staff.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700' }} transition-all">
                        <i class="fas fa-satellite-dish text-xs"></i>
                    </div>
                    Execution Grid
                </a>

                <a href="{{ route('staff.complaints') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group {{ request()->routeIs('staff.complaints') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('staff.complaints') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700' }} transition-all">
                        <i class="fas fa-radar text-xs"></i>
                    </div>
                    Issue Radar
                </a>

                <a href="{{ route('staff.print') }}" target="_blank" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200 transition-colors">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700 transition-all text-slate-400 group-hover:text-slate-900 dark:group-hover:text-white">
                        <i class="fas fa-print text-xs"></i>
                    </div>
                    Print Manifest
                </a>

                <div class="mt-8 pt-8 border-t border-slate-200 dark:border-slate-800">
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Account</h3>
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('profile.edit') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700' }} transition-all">
                            <i class="fas fa-user-circle text-xs"></i>
                        </div>
                        My Profile
                    </a>
                </div>
            </nav>
        </div>
    </div>
    
    <div class="mb-4">
        <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl p-4 flex items-center gap-3">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 text-white"></span>
            </span>
            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest leading-none">Uplink Active</span>
        </div>
    </div>
</div>

