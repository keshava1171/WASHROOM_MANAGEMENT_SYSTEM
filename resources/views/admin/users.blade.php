@extends('layouts.app')

@section('title', 'User Management | WMS')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    
    <div class="animate-fade-in-up">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">User Management</h1>
        <p class="text-slate-600 dark:text-slate-400">Manage system users and access permissions</p>
    </div>

    
    <div class="premium-card p-4 animate-fade-in-up">
        <form method="GET" action="{{ url('/admin/users') }}" class="flex flex-wrap md:flex-nowrap items-center justify-between gap-4">
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-4 w-full md:w-auto flex-1">
                <div class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users by name or email..." 
                           class="input-premium pl-11 py-2 text-sm w-full">
                    <i class="fas fa-search absolute left-4 top-3 text-slate-400"></i>
                </div>
                <select name="role" class="input-premium py-2 text-sm w-full sm:w-40 bg-slate-50">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                </select>
                <select name="status" class="input-premium py-2 text-sm w-full sm:w-40 bg-slate-50">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Verified</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto justify-end flex-none">
                @if(request()->anyFilled(['search', 'role', 'status']))
                    <a href="{{ url('/admin/users') }}" class="btn-secondary py-2 px-4 shadow-sm text-sm flex items-center">
                         <i class="fas fa-rotate-left mr-2"></i> Clear
                    </a>
                @endif
                <button type="submit" class="btn-primary py-2 px-6 shadow-sm text-sm">
                    <i class="fas fa-filter mr-2"></i> Filter Rules
                </button>
                <div class="h-8 w-[1px] bg-slate-200 mx-1 hidden md:block"></div>
                <a href="{{ url('/admin/staff/create') }}" class="btn-primary py-2 px-4 shadow-sm text-sm !bg-indigo-600 hover:!bg-indigo-700">
                    <i class="fas fa-user-plus mr-2"></i> Add Staff
                </a>
            </div>
        </form>
    </div>

    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="premium-card p-4 animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ $users->where('role', 'admin')->count() }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Administrators</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 dark:bg-rose-500/20 flex items-center justify-center border border-rose-100 dark:border-rose-500/30">
                    <i class="fas fa-shield-alt text-rose-500 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="premium-card p-4 animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ $users->where('role', 'staff')->count() }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Staff Members</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-500/20 flex items-center justify-center border border-primary-100 dark:border-primary-500/30">
                    <i class="fas fa-id-badge text-primary-500 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="premium-card p-4 animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ $users->where('role', 'user')->count() }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Regular Users</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/20 flex items-center justify-center border border-emerald-100 dark:border-emerald-500/30">
                    <i class="fas fa-users text-emerald-500 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="premium-card p-4 animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1">{{ $users->count() }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Total Accounts</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center border border-slate-200 dark:border-slate-600">
                    <i class="fas fa-layer-group text-slate-500 dark:text-slate-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    
    <div class="premium-card overflow-hidden animate-fade-in-up flex flex-col" style="animation-delay: 0.5s">
        <div class="p-6 border-b border-slate-200 dark:border-dark-border flex items-center justify-between bg-white dark:bg-dark-surface">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center">
                <i class="fas fa-address-book w-6 text-primary-500"></i> Registry Leads
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ url('/admin/users/export') }}" class="text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors uppercase tracking-widest flex items-center">
                    <i class="fas fa-file-csv mr-2 text-sm"></i> Export Registry (CSV)
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-dark-border">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pointer-events-none">Link Target</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pointer-events-none">Role Access</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pointer-events-none">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pointer-events-none">Connection Info</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest text-right pointer-events-none">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @forelse($users as $user)
                        <tr id="user-{{ $user->id }}" class="hover:bg-slate-50 dark:hover:bg-slate-800/20 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-200 to-slate-100 dark:from-slate-700 dark:to-slate-800 shadow-sm border border-slate-300 dark:border-slate-600 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center mt-0.5">
                                            <i class="fas fa-envelope text-slate-400 mr-1 text-xs"></i> {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20 uppercase tracking-wider">
                                        <i class="fas fa-shield-alt mr-1.5"></i> Admin
                                    </span>
                                @elseif($user->role === 'staff')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400 border border-primary-200 dark:border-primary-500/20 uppercase tracking-wider">
                                        <i class="fas fa-id-badge mr-1.5"></i> Staff
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700 uppercase tracking-wider">
                                        <i class="fas fa-user mr-1.5"></i> User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->email_verified_at)
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_5px_rgba(16,185,129,0.5)]"></span>
                                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Verified</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_5px_rgba(245,158,11,0.5)]"></span>
                                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Pending</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    <div class="mb-1"><strong class="text-slate-700 dark:text-slate-300">Joined:</strong> {{ $user->created_at->format('M j, Y') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-500/10 transition-colors" title="Manage Identity">
                                        <i class="fas fa-pen-to-square"></i>
                                    </button>

                                    @if($user->role === 'staff')
                                        <form action="{{ route('admin.users.resend-welcome', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-500/10 transition-colors" title="Resend Welcome Uplink">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($user->role !== 'admin' || collect($users)->where('role', 'admin')->count() > 1)
                                        <form action="{{ url('/admin/users/' . $user->id) }}" method="POST" onsubmit="return confirm('Eradicate user from existence?')" data-ajax-form data-delete-target="user-{{ $user->id }}" class="inline-block">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors" title="Delete User">
                                                <i class="fas fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                <i class="fas fa-folder-open text-4xl mb-4 opacity-50 block"></i>
                                No active records found in the current segment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($users, 'hasPages') && $users->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-dark-border bg-slate-50 dark:bg-slate-800/50 flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                    Showing {{ $users->firstItem() }} - {{ $users->lastItem() }} of {{ $users->total() }} results
                </div>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
