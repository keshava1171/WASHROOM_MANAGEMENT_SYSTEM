@extends('layouts.app')

@section('title', 'Verify Email - WMS Portal')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-4 py-12 relative overflow-hidden">
    
    <div class="absolute inset-0 z-0">
        <div class="absolute left-[30%] top-[20%] w-96 h-96 bg-amber-500/10 dark:bg-amber-500/5 rounded-full blur-3xl animate-pulse-slow"></div>
    </div>

    <div class="w-full max-w-lg relative z-10">
        <div class="premium-card p-8 shadow-2xl animate-fade-in-up">
            
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-amber-500/40 relative">
                    <i class="fas fa-envelope-open-text text-white text-3xl"></i>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center ring-4 ring-white dark:ring-dark-surface animate-bounce">!</div>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2">Verify Your Email</h2>
                <p class="text-slate-500 dark:text-slate-400">Security verification required</p>
            </div>

            <div class="bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/30 rounded-2xl p-6 mb-8 text-center text-sm font-medium text-amber-800 dark:text-amber-300 shadow-sm leading-relaxed">
                Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </div>

            @if (session('message') == 'Verification link sent!')
                <div class="mb-8 p-4 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 rounded-xl flex items-center shadow-sm animate-zoom-in text-sm font-semibold text-emerald-800 dark:text-emerald-300">
                    <i class="fas fa-paper-plane mr-3 text-emerald-500"></i>
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-8 mb-8">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-slate-900 hover:bg-slate-800 dark:bg-white dark:hover:bg-slate-100 text-white dark:text-slate-900 font-bold rounded-xl transition-all shadow-lg active:scale-95 group">
                        <i class="fas fa-sync-alt mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-bold text-slate-500 dark:text-slate-400 hover:text-red-500 dark:hover:text-red-400 dark:bg-slate-800/50 dark:hover:bg-red-500/10 bg-slate-100 hover:bg-red-50 rounded-xl transition-colors text-center border border-transparent dark:border-slate-700">
                        <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                    </button>
                </form>
            </div>

            
            <div class="pt-2">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i class="fas fa-pen-nib text-indigo-500"></i> Incorrect Uplink Address?
                </h3>
                <form method="POST" action="{{ route('verification.update_email') }}" class="space-y-4">
                    @csrf
                    <div class="relative group">
                        <input type="email" name="email" value="{{ auth()->user()->email }}" required 
                               class="w-full px-5 py-3.5 bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-200 dark:border-slate-800 rounded-xl focus:border-indigo-500 focus:ring-0 outline-none transition-all dark:text-white font-bold text-sm">
                        <i class="fas fa-at absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-[0.2em] rounded-xl shadow-lg shadow-indigo-500/30 transition-all active:scale-[0.98]">
                        Sync New Uplink & Resend
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

