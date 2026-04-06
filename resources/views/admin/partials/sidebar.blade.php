<div class="h-full flex flex-col justify-between">
    <div>
        <div class="mb-8">
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Admin Controls</h3>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700' }} transition-all">
                        <i class="fas fa-chart-pie text-xs"></i>
                    </div>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.structure') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group {{ request()->routeIs('admin.structure') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.structure') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700' }} transition-all">
                        <i class="fas fa-building text-xs"></i>
                    </div>
                    Structure / Floors
                </a>

                <a href="{{ route('admin.tasks') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group {{ request()->routeIs('admin.tasks') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.tasks') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700' }} transition-all">
                        <i class="fas fa-clipboard-list text-xs"></i>
                    </div>
                    Task Assignments
                </a>

                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group {{ request()->routeIs('admin.users') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.users') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700' }} transition-all">
                        <i class="fas fa-users text-xs"></i>
                    </div>
                    User Management
                </a>

                <a href="{{ route('admin.complaints') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group {{ request()->routeIs('admin.complaints') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.complaints') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700' }} transition-all">
                        <i class="fas fa-exclamation-triangle text-xs"></i>
                    </div>
                    Complaints
                </a>
            </nav>
        </div>

        <div>
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Database Registries</h3>
            <nav class="space-y-1">
                <a href="{{ route('admin.registry.users') }}" class="flex items-center px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.registry.users') ? 'text-indigo-600' : 'text-slate-500' }} hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <i class="fas fa-id-badge w-6 text-xs opacity-50"></i> Users Registry
                </a>
                <a href="{{ route('admin.registry.logs') }}" class="flex items-center px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.registry.logs') ? 'text-indigo-600' : 'text-slate-500' }} hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <i class="fas fa-history w-6 text-xs opacity-50"></i> Operation Logs
                </a>
                <a href="{{ route('admin.registry.assets') }}" class="flex items-center px-4 py-2 text-sm font-medium {{ request()->routeIs('admin.registry.assets') ? 'text-indigo-600' : 'text-slate-500' }} hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <i class="fas fa-microchip w-6 text-xs opacity-50"></i> Asset DB
                </a>
            </nav>
        </div>
        <div class="mt-8 pt-8 border-t border-slate-200 dark:border-slate-800">
            <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Account</h3>
            <nav class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl group {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200' }} transition-colors">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('profile.edit') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-slate-100 dark:bg-slate-800 group-hover:bg-slate-200 dark:group-hover:bg-slate-700' }} transition-all">
                        <i class="fas fa-user-circle text-xs"></i>
                    </div>
                    My Profile
                </a>
            </nav>
        </div>
    </div>
</div>

