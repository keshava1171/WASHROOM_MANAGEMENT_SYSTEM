<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'WMS'))</title>

    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554',
                        },
                        secondary: {
                            50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4', 300: '#5eead4', 400: '#2dd4bf',
                            500: '#14b8a6', 600: '#0d9488', 700: '#0f766e', 800: '#115e59', 900: '#134e4a', 950: '#042f2e',
                        },
                        dark: {
                            bg: '#0f172a',
                            surface: '#111827',
                            border: '#3b82f640'
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                        'zoom-in': 'zoomIn 0.4s ease-out forwards',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        zoomIn: {
                            '0%': { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        }
                    }
                }
            }
        }
        

        function initTheme() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.classList.toggle('dark', theme === 'dark');
            if (typeof updateThemeIcon === 'function') updateThemeIcon();
        }
        

        initTheme();

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const icon = document.getElementById('theme-icon');
            if(icon) {
                if (document.documentElement.classList.contains('dark')) {
                    icon.classList.replace('fa-moon', 'fa-sun');
                } else {
                    icon.classList.replace('fa-sun', 'fa-moon');
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', updateThemeIcon);
    </script>
    <style type="text/tailwindcss">
        
        body {
            @apply bg-slate-50 text-slate-800 dark:bg-dark-bg dark:text-slate-200 transition-colors duration-300;
        }

        
        .glass-panel {
            @apply bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border border-white/20 dark:border-indigo-500/20 shadow-xl;
        }
        
        .glass-navbar {
            @apply bg-white/90 dark:bg-slate-900/95 backdrop-blur-lg border-b border-slate-200 dark:border-indigo-500/20 shadow-sm sticky top-0 z-50;
        }

        
        .input-premium {
            @apply w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-300 dark:border-indigo-500/20 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all shadow-sm dark:text-white placeholder-slate-400 dark:placeholder-slate-500;
        }

        
        .btn-primary {
            @apply inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-all shadow-lg shadow-indigo-500/30 hover:shadow-indigo-600/50 hover:-translate-y-0.5 active:translate-y-0;
        }
        .btn-secondary {
            @apply inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-slate-800 border border-slate-300 dark:border-indigo-500/20 text-slate-700 dark:text-slate-300 font-medium rounded-xl transition-all hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm hover:-translate-y-0.5 active:translate-y-0;
        }

        
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            @apply bg-transparent;
        }
        ::-webkit-scrollbar-thumb {
            @apply bg-slate-400 dark:bg-slate-500;
        }
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-slate-400 dark:bg-slate-500;
        }

        
        .premium-card {
            @apply bg-white/70 dark:bg-slate-900/60 backdrop-blur-[40px] rounded-[2.75rem] border-[3px] border-slate-200/60 dark:border-indigo-500/40 shadow-2xl shadow-indigo-500/5 dark:shadow-[0_0_50px_rgba(79,70,229,0.15)] transition-all duration-500 relative overflow-hidden;
        }
        .premium-card::before {
            content: '';
            @apply absolute inset-0 bg-gradient-to-br from-indigo-500/[0.03] to-transparent pointer-events-none;
        }

        .tactical-box {
            @apply p-6 rounded-[2rem] bg-slate-100/50 dark:bg-indigo-950/20 border-[3px] border-slate-200/60 dark:border-indigo-500/30 backdrop-blur-3xl shadow-lg transition-all duration-300;
        }

        .tactical-input {
            @apply flex-1 bg-slate-50 dark:bg-slate-900/90 border-[3px] border-slate-200/60 dark:border-indigo-500/30 rounded-2xl py-4 px-6 text-slate-900 dark:text-white transition-all font-black text-sm tracking-tight backdrop-blur-2xl shadow-inner;
        }
        .tactical-input:focus {
            @apply border-indigo-500 outline-none ring-8 ring-indigo-500/10 bg-white dark:bg-slate-950;
        }

        
        .input-group-tactical {
            @apply flex items-center gap-4 w-full;
        }
        .icon-box-tactical {
            @apply w-14 h-14 flex-none rounded-2xl bg-slate-100/80 dark:bg-slate-800/80 border-[3px] border-slate-200/60 dark:border-indigo-500/30 text-slate-500 dark:text-indigo-400 flex items-center justify-center text-xl shadow-sm transition-all duration-300 backdrop-blur-xl;
        }
        .input-group-tactical:focus-within .icon-box-tactical {
            @apply border-indigo-500 text-indigo-600 dark:text-white shadow-lg shadow-indigo-500/20 scale-105;
        }
        
        
        .layout-with-sidebar {
            @apply flex h-[calc(100vh-4rem)]; 
            overflow: hidden;
        }
        .sidebar-container {
            @apply w-64 flex-none border-r border-slate-200 dark:border-indigo-500/20 bg-white dark:bg-slate-900 h-full overflow-y-auto hidden md:block transition-all;
        }
        .main-content-area {
            @apply flex-1 h-full overflow-y-auto bg-slate-50 dark:bg-dark-bg p-4 md:p-8;
        }
        
        
        .status-badge {
            @apply px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider inline-flex items-center justify-center;
        }
        .status-badge.pending { @apply bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30; }
        .status-badge.in_progress { @apply bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/30; }
        .status-badge.resolved { @apply bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    
    <nav class="glass-navbar border-b h-16 flex items-center">
        <div class="container mx-auto px-4 md:px-8 w-full">
            <div class="flex items-center justify-between">
                
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center shadow-lg group-hover:shadow-primary-500/50 transition-all group-hover:scale-105">
                        <i class="fas fa-hospital text-white"></i>
                    </div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 dark:from-white dark:to-slate-400">
                        WMS
                    </span>
                </a>

                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Home</a>
                    @if(auth()->check())
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isStaff() ? route('staff.dashboard') : route('dashboard')) }}" class="text-base font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            {{ auth()->user()->isAdmin() ? 'Admin Portal' : (auth()->user()->isStaff() ? 'Staff Portal' : 'Tracking Hub') }}
                        </a>
                        @if(auth()->user()->role === 'user')
                            <a href="{{ route('complaints.create') }}" class="text-base font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Report Issue</a>
                        @endif
                    @else
                        <a href="{{ route('complaints.create') }}" class="text-base font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Report Issue</a>
                    @endif
                </div>

                
                <div class="flex items-center gap-3">
                    @if(auth()->check() && in_array(auth()->user()->role, ['admin','staff']))
                        @php $pendingCount = \App\Models\Complaint::where('status','pending')->count(); @endphp
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.complaints') : route('staff.complaints') }}" class="relative w-10 h-10 rounded-full flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-amber-50 dark:hover:bg-amber-500/10 hover:text-amber-500 transition-all shadow-sm ring-1 ring-slate-200 dark:ring-slate-700" title="Complaints">
                            <i class="fas fa-bell text-base"></i>
                            @if($pendingCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">{{ $pendingCount > 9 ? '9+' : $pendingCount }}</span>
                            @endif
                        </a>
                    @endif
                    
                    <button onclick="toggleTheme()" class="w-10 h-10 rounded-full flex items-center justify-center bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 transition-all shadow-sm ring-1 ring-slate-200 dark:ring-slate-700" aria-label="Toggle Dark Mode" title="Toggle Theme">
                        <i class="fas fa-moon text-base" id="theme-icon"></i>
                    </button>

                    @guest
                        <div class="hidden md:flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"><i class="fas fa-shield-alt mr-1"></i> Admin Login</a>
                            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"><i class="fas fa-id-badge mr-1"></i> Staff Login</a>
                            <div class="w-px h-6 bg-slate-300 dark:bg-slate-700"></div>
                            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">User Sign In</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-bold rounded-lg transition-colors shadow-md shadow-primary-500/20">Register</a>
                        </div>
                    @else
                        
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                                <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 text-primary-600 dark:text-primary-300 flex items-center justify-center font-bold text-xs ring-2 ring-white dark:ring-slate-800">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium hidden sm:block text-slate-700 dark:text-slate-200">
                                    {{ auth()->user()->name }}
                                </span>
                                <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                            </button>
                            
                            
                            <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform origin-top-right z-50">
                                <div class="p-2 border-b border-slate-100 dark:border-slate-700">
                                    <p class="text-xs text-slate-500 dark:text-slate-400 px-3 truncate">{{ auth()->user()->email }}</p>
                                    <p class="text-xs font-bold uppercase tracking-wider text-primary-600 dark:text-primary-400 px-3 mt-1">{{ auth()->user()->role }}</p>
                                </div>
                                <div class="p-2 space-y-1">
                                    <a href="{{ route('profile.edit') }}" class="w-full text-left px-3 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg transition-colors flex items-center gap-2">
                                        <i class="fas fa-user-circle"></i> My Profile
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg transition-colors flex items-center gap-2">
                                            <i class="fas fa-sign-out-alt"></i> Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest

                    
                    <button class="md:hidden w-10 h-10 flex items-center justify-center text-slate-600 dark:text-slate-300" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    
    
    <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 absolute w-full z-40 shadow-lg">
        <div class="px-4 py-4 flex flex-col space-y-3">
            <a href="{{ route('home') }}" class="text-base font-medium text-slate-700 dark:text-slate-200 py-2">Home</a>
            @if(auth()->check())
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isStaff() ? route('staff.dashboard') : route('dashboard')) }}" class="text-base font-medium text-slate-700 dark:text-slate-200 py-2">
                    {{ auth()->user()->isAdmin() ? 'Admin Portal' : (auth()->user()->isStaff() ? 'Staff Portal' : 'Tracking Hub') }}
                </a>
            @else
                <a href="{{ route('login') }}" class="text-base font-medium text-slate-700 dark:text-slate-200 py-2"><i class="fas fa-shield-alt w-6"></i> Admin Login</a>
                <a href="{{ route('login') }}" class="text-base font-medium text-slate-700 dark:text-slate-200 py-2"><i class="fas fa-id-badge w-6"></i> Staff Login</a>
                <hr class="border-slate-200 dark:border-slate-800 my-1">
                <a href="{{ route('login') }}" class="text-base font-medium text-slate-700 dark:text-slate-200 py-2"><i class="fas fa-user w-6"></i> User Sign In</a>
                <a href="{{ route('register') }}" class="text-base font-medium text-primary-600 py-2"><i class="fas fa-user-plus w-6"></i> Register</a>
            @endif
        </div>
    </div>

    
    @hasSection('sidebar')
        
        <div class="layout-with-sidebar flex-1">
            <aside class="sidebar-container">
                <div class="p-6 space-y-8">
                    @yield('sidebar')
                </div>
            </aside>
            <main class="main-content-area relative">
                @include('layouts.partials.flash-messages')
                @yield('content')
            </main>
        </div>
    @else
        
        <main class="flex-1 w-full relative">
            @include('layouts.partials.flash-messages')
            @yield('content')
        </main>
    @endif

    
    <div id="toast-container" class="fixed bottom-8 right-8 z-[100] flex flex-col gap-4 pointer-events-none"></div>

    <script>
        
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const colors = {
                success: 'from-emerald-500 to-teal-600 border-emerald-400',
                error: 'from-rose-500 to-pink-600 border-rose-400',
                info: 'from-indigo-500 to-blue-600 border-indigo-400',
                warning: 'from-amber-500 to-orange-600 border-amber-400'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-triangle',
                info: 'fa-info-circle',
                warning: 'fa-exclamation-circle'
            };

            toast.className = `max-w-md bg-gradient-to-br ${colors[type]} border-2 text-white p-4 rounded-2xl shadow-2xl transition-all duration-500 transform translate-x-full opacity-0 flex items-center gap-4 pointer-events-auto`;
            toast.innerHTML = `
                <div class="w-10 h-10 rounded-xl bg-white/20 flex-none flex items-center justify-center text-xl shadow-inner">
                    <i class="fas ${icons[type]}"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-black uppercase tracking-widest leading-tight">${type === 'success' ? 'Synchronized' : 'Operational Warning'}</p>
                    <p class="text-[13px] font-bold opacity-90">${message}</p>
                </div>
            `;

            container.appendChild(toast);
            

            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            });

            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 6000);
        }

        
        document.addEventListener('submit', async (e) => {
            const form = e.target;
            if (!form.hasAttribute('data-ajax-form')) return;

            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalContent = submitBtn ? submitBtn.innerHTML : '';
            const deleteTarget = form.getAttribute('data-delete-target');
            
            if (submitBtn) {
                submitBtn.disabled = true;
                if (form.method.toLowerCase() === 'delete') {
                    submitBtn.innerHTML = '<i class="fas fa-satellite-dish animate-pulse"></i> Terminating...';
                } else {
                    submitBtn.innerHTML = '<i class="fas fa-sync animate-spin"></i> Syncing...';
                }
            }

            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                });

                const result = await response.json();

                if (response.ok) {
                    showToast(result.message || 'Operation successful', 'success');
                    

                    if (deleteTarget) {
                        const targetEl = document.getElementById(deleteTarget);
                        if (targetEl) {
                            targetEl.classList.add('opacity-0', 'scale-95', 'blur-sm');
                            targetEl.style.transition = 'all 0.4s ease';
                            setTimeout(() => targetEl.remove(), 400);
                        }
                    }

                    if (result.updates) {
                        Object.keys(result.updates).forEach(selector => {
                            const elements = document.querySelectorAll(`[data-sync-field="${selector}"]`);
                            elements.forEach(el => {
                                el.innerHTML = result.updates[selector];
                                el.classList.add('animate-pulse');
                                setTimeout(() => el.classList.remove('animate-pulse'), 2000);
                            });
                        });
                    }

                    window.dispatchEvent(new CustomEvent('tactical-sync-success', { detail: { form, result } }));

                } else {
                    const errorMsg = result.message || Object.values(result.errors || {}).flat()[0] || 'Operational failure';
                    showToast(errorMsg, 'error');
                }
            } catch (error) {
                console.error('TacticalSync Error:', error);
                showToast('Intelligence uplink failed. Check your connection.', 'error');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                }
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.alert-dismissible');
            if (alerts.length > 0) {
                setTimeout(() => {
                    alerts.forEach(alert => {
                        alert.classList.add('opacity-0', '-translate-y-4');
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 5000);
            }
        });
    </script>
</body>
</html>

