@extends('layouts.app')

@section('title', 'Sign In - WMS Portal')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-4 py-12 relative overflow-hidden">
    
    <div class="absolute inset-0 z-0">
        <div class="absolute right-[10%] top-[10%] w-96 h-96 bg-primary-500/10 dark:bg-primary-500/5 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute left-[10%] bottom-[10%] w-80 h-80 bg-secondary-500/10 dark:bg-secondary-500/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="premium-card p-8 shadow-2xl animate-fade-in-up">
            
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-primary-500/40 transform hover:rotate-12 transition-transform duration-300">
                    <i class="fas fa-hospital text-white text-3xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2">Welcome Back</h2>
                <p class="text-slate-500 dark:text-slate-400">Sign in to your account</p>
                
                <div class="mt-4 p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-left">
                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2 flex items-center gap-2">
                        <i class="fas fa-shield-halved text-primary-500"></i> Tactical Access
                    </p>
                    <div class="text-[10px] font-bold text-slate-600 dark:text-slate-400">
                        <span class="block opacity-50 uppercase text-[8px]">Root Admin Account</span>
                        admin@wms.com / password123
                    </div>
                </div>
            </div>

            
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                        <div class="input-group-tactical">
                            <div class="icon-box-tactical">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                                   class="tactical-input w-full" placeholder="Enter your email">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Password</label>
                            <a href="#" class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-500 transition-colors">Forgot password?</a>
                        </div>
                        <div class="input-group-tactical">
                            <div class="icon-box-tactical">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="relative flex-1 group">
                                <input id="password" name="password" type="password" required autocomplete="current-password"
                                       class="tactical-input pr-12 w-full" placeholder="Enter your password">
                                <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary-500 transition-colors focus:outline-none">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" name="remember" class="peer appearance-none w-5 h-5 border-[3px] border-slate-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-800 checked:bg-primary-600 checked:border-primary-600 transition-all cursor-pointer focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                            <i class="fas fa-check absolute text-xs text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></i>
                        </div>
                        <span class="text-sm text-slate-600 dark:text-slate-400 font-medium group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="w-full btn-primary group relative overflow-hidden">
                    <span class="relative z-10 flex items-center gap-2 text-base font-bold tracking-wide">
                        <i class="fas fa-sign-in-alt group-hover:translate-x-1 transition-transform"></i>
                        Authenticate
                    </span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700/50 text-center">
                <p class="text-slate-500 dark:text-slate-400 text-sm">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-bold text-primary-600 dark:text-primary-400 hover:underline hover:text-primary-500 transition-all">
                        Create an account
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection

