@extends('layouts.app')

@section('title', 'Users Registry | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Users Registry</h1>
            <p class="text-slate-600 dark:text-slate-400 text-sm">Full index of facility maintenance and administrative personnel.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary px-4 py-2 text-xs font-bold uppercase tracking-widest bg-slate-100 dark:bg-slate-800">
            <i class="fas fa-arrow-left mr-2"></i> Dashboard
        </a>
    </div>

    
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">ID</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Name</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Email</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Role</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Email Verified</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 text-right">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 text-xs font-black text-slate-400">#{{ $user->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-500/10 text-indigo-500 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 italic">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest 
                                    {{ $user->role === 'admin' ? 'bg-rose-500/10 text-rose-500' : 'bg-indigo-500/10 text-indigo-500' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->email_verified_at)
                                    <span class="flex items-center text-emerald-500 text-[10px] font-black uppercase tracking-widest">
                                        <i class="fas fa-check-circle mr-1.5"></i> Verified
                                    </span>
                                @else
                                    <span class="flex items-center text-amber-500 text-[10px] font-black uppercase tracking-widest">
                                        <i class="fas fa-exclamation-circle mr-1.5"></i> Not Verified
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-[10px] font-bold text-slate-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-900/30">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

