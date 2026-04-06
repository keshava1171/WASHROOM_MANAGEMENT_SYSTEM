@extends('layouts.app')

@section('title', 'Users Database | Admin | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Users Directory</h1>
            <p class="text-sm text-slate-500 font-bold uppercase tracking-widest mt-1">MySQL Database</p>
        </div>
        <a href="{{ route('admin.users') }}" class="btn-secondary py-2 px-4 text-xs font-black">
            <i class="fas fa-plus mr-2"></i> Manage Users
        </a>
    </div>

    @include('layouts.partials.flash-messages')

    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">ID</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Identity</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Role</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Verification</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @foreach($data as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-colors">
                        <td class="px-6 py-4 font-mono text-[10px] text-slate-400 group relative">
                            {{ $user->_id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-black text-xs">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 dark:text-white tracking-tight">{{ $user->name }}</p>
                                    <p class="text-[10px] text-slate-500 font-bold tracking-widest italic">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->email_verified_at)
                                <div class="flex items-center gap-1.5 text-emerald-500 text-[10px] font-black uppercase tracking-widest">
                                    <i class="fas fa-check-circle"></i> VERIFIED
                                </div>
                            @else
                                <div class="flex items-center gap-1.5 text-amber-500 text-[10px] font-black uppercase tracking-widest">
                                    <i class="fas fa-exclamation-circle animate-pulse"></i> PENDING
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-[10px] text-slate-500 font-bold uppercase tracking-widest">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($data->hasPages())
        <div class="p-6 border-t border-slate-100 dark:border-slate-800">
            {{ $data->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

