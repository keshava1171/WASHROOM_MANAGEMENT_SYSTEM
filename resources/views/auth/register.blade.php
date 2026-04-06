@extends('layouts.app')

@section('title', 'Create Account - WMS Portal')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-4 py-12 relative overflow-hidden">
    
    <div class="absolute inset-0 z-0">
        <div class="absolute left-[10%] top-[10%] w-96 h-96 bg-primary-500/10 dark:bg-primary-500/5 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute right-[10%] bottom-[10%] w-80 h-80 bg-secondary-500/10 dark:bg-secondary-500/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="w-full max-w-lg relative z-10">
        <div class="premium-card p-8 shadow-2xl animate-fade-in-up">
            
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-gradient-to-br from-secondary-500 to-secondary-700 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-secondary-500/40 transform hover:-rotate-12 transition-transform duration-300">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2">Create Account</h2>
                <p class="text-slate-500 dark:text-slate-400">Join the WMS platform to report issues seamlessly</p>
            </div>

            
            <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Full Name</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-secondary-500 transition-colors">
                                <i class="fas fa-user"></i>
                            </div>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                   class="input-premium !pl-11 focus:border-secondary-500 focus:ring-secondary-500" placeholder="John Doe">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-secondary-500 transition-colors">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                   class="input-premium !pl-11 focus:border-secondary-500 focus:ring-secondary-500" placeholder="john@example.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-secondary-500 transition-colors">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input id="password" name="password" type="password" required
                                       class="input-premium !pl-11 pr-12 focus:border-secondary-500 focus:ring-secondary-500" placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-secondary-500 transition-colors">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Confirm Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-secondary-500 transition-colors">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                       class="input-premium !pl-11 pr-12 focus:border-secondary-500 focus:ring-secondary-500" placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-secondary-500 transition-colors">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required class="w-5 h-5 border-2 border-slate-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-800 checked:bg-secondary-600 checked:border-secondary-600 focus:ring-2 focus:ring-secondary-500 transition-all cursor-pointer relative appearance-none checked:bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg%20viewBox=%220%200%2016%2016%22%20fill=%22white%22%20xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath%20d=%22M12.207%204.793a1%201%200%20010%201.414l-5%205a1%201%200%2001-1.414%200l-2-2a1%201%200%20011.414-1.414L6.5%209.086l4.293-4.293a1%201%200%20011.414%200z%22/%3E%3C/svg%3E')] bg-center bg-no-repeat bg-[length:100%_100%]">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-slate-600 dark:text-slate-400">
                            I accept the <a href="#" class="text-secondary-600 dark:text-secondary-400 hover:text-secondary-500 font-bold transition-colors">Terms of Service</a> and <a href="#" class="text-secondary-600 dark:text-secondary-400 hover:text-secondary-500 font-bold transition-colors">Privacy Policy</a>.
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-xl transition-all shadow-lg shadow-secondary-500/30 hover:shadow-secondary-600/50 hover:-translate-y-0.5 group relative overflow-hidden">
                    <span class="relative z-10 flex items-center gap-2 text-base font-bold tracking-wide">
                        <i class="fas fa-user-plus group-hover:scale-110 transition-transform"></i>
                        Register Account
                    </span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700/50 text-center">
                <p class="text-slate-500 dark:text-slate-400 text-sm">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-bold text-secondary-600 dark:text-secondary-400 hover:underline hover:text-secondary-500 transition-all">
                        Sign in instead
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

