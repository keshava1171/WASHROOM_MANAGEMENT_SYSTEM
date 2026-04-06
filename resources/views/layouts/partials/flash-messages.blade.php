@if(session('info'))
    <div class="alert-dismissible mb-6 p-4 bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-500/30 rounded-2xl flex items-center shadow-sm dark:shadow-indigo-500/5 animate-zoom-in transition-all">
        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex flex-shrink-0 flex-none items-center justify-center mr-4">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="text-sm font-semibold text-indigo-800 dark:text-indigo-300">{{ session('info') }}</div>
    </div>
@endif

@if(session('warning'))
    <div class="alert-dismissible mb-6 p-4 bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/30 rounded-2xl flex items-center shadow-sm dark:shadow-amber-500/5 animate-zoom-in transition-all">
        <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex flex-shrink-0 flex-none items-center justify-center mr-4">
            <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div class="text-sm font-semibold text-amber-800 dark:text-amber-300">{{ session('warning') }}</div>
    </div>
@endif

@if(session('success'))
    <div class="alert-dismissible mb-6 p-4 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 rounded-2xl flex items-center shadow-sm dark:shadow-emerald-500/5 animate-zoom-in transition-all">
        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex flex-shrink-0 flex-none items-center justify-center mr-4">
            <i class="fas fa-check"></i>
        </div>
        <div class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</div>
    </div>
@endif

@if(session('error') || $errors->any())
    <div class="alert-dismissible mb-6 p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/30 rounded-2xl flex items-start shadow-sm dark:shadow-red-500/5 animate-zoom-in transition-all">
        <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 flex items-center justify-center mr-4 flex-shrink-0">
            <i class="fas fa-circle-xmark"></i>
        </div>
        <div>
            <div class="text-sm font-semibold text-red-800 dark:text-red-300 block mb-1">
                {{ session('error') ?? 'Authentication or Validation Error' }}
            </div>
            @if($errors->any())
                <ul class="text-xs text-red-700 dark:text-red-400 space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endif

