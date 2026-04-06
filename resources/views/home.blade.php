@extends('layouts.app')

@section('title', 'WMS - Intelligent Washroom Management')

@section('content')

<section class="relative min-h-[calc(100vh-4rem)] flex items-center justify-center overflow-hidden">
    
    <div class="absolute inset-0 z-0">
        <div class="absolute right-[0%] top-[0%] w-[500px] h-[500px] bg-primary-500/10 dark:bg-primary-500/5 rounded-full blur-[100px] animate-pulse-slow"></div>
        <div class="absolute left-[0%] bottom-[0%] w-[500px] h-[500px] bg-secondary-500/10 dark:bg-secondary-500/5 rounded-full blur-[100px] animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10 text-center">
        <div class="animate-fade-in-up max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400 font-bold text-sm mb-6 border border-primary-100 dark:border-primary-500/20 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                System Operational
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight text-slate-900 dark:text-white">
                <span class="block">Intelligent</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-500 dark:from-primary-400 dark:to-secondary-400">
                    Facility Monitoring
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 mb-10 max-w-3xl mx-auto leading-relaxed">
                Advanced hospital washroom management system with real-time monitoring, 
                automated task assignment, and comprehensive hygiene compliance tracking.
            </p>
            
            @if(auth()->check())
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isStaff() ? route('staff.dashboard') : route('dashboard')) }}" class="btn-primary px-8 py-4 text-lg w-full sm:w-auto">
                        <i class="fas fa-tachometer-alt mr-2"></i> Access Dashboard
                    </a>
                    <a href="#features" class="btn-secondary px-8 py-4 text-lg w-full sm:w-auto">
                        <i class="fas fa-info-circle mr-2"></i> System Features
                    </a>
                </div>
            @else
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="btn-primary px-8 py-4 text-lg w-full sm:w-auto">
                        <i class="fas fa-user-plus mr-2"></i> Join Platform
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary px-8 py-4 text-lg w-full sm:w-auto text-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="py-20 bg-slate-50 dark:bg-slate-900/50 border-y border-slate-200 dark:border-slate-800">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative z-10">
            <div class="premium-card p-8 text-center animate-fade-in-up bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm">
                <div class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-primary-400 mb-2">98%</div>
                <div class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Compliance Rate</div>
            </div>
            <div class="premium-card p-8 text-center animate-fade-in-up bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm" style="animation-delay: 0.1s">
                <div class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-secondary-600 to-secondary-400 mb-2">24/7</div>
                <div class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Monitoring</div>
            </div>
            <div class="premium-card p-8 text-center animate-fade-in-up bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm" style="animation-delay: 0.2s">
                <div class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-emerald-400 mb-2">500+</div>
                <div class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Facilities</div>
            </div>
            <div class="premium-card p-8 text-center animate-fade-in-up bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm" style="animation-delay: 0.3s">
                <div class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-orange-400 mb-2">15min</div>
                <div class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Response Time</div>
            </div>
        </div>
    </div>
</section>

<section id="features" class="py-24 relative">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-6 tracking-tight">Advanced Features</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400">
                Cutting-edge technology designed to optimize hospital hygiene management, ensuring top-tier sanitation levels.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="premium-card p-8 animate-fade-in-up group">
                <div class="w-14 h-14 rounded-2xl bg-primary-100 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Organized Structure</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Hierarchical facility management with Floor → Room → Washroom mapping for precise control.
                </p>
            </div>
            
            <div class="premium-card p-8 animate-fade-in-up group" style="animation-delay: 0.1s">
                <div class="w-14 h-14 rounded-2xl bg-secondary-100 dark:bg-secondary-500/20 text-secondary-600 dark:text-secondary-400 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fas fa-print"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Offline Ready</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    High-contrast printable manifests for staff working in areas without digital access.
                </p>
            </div>
            
            <div class="premium-card p-8 animate-fade-in-up group" style="animation-delay: 0.2s">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Real-time Analytics</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Comprehensive reporting and analytics for performance monitoring and compliance tracking.
                </p>
            </div>
            
            <div class="premium-card p-8 animate-fade-in-up group" style="animation-delay: 0.3s">
                <div class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-500/20 text-orange-600 dark:text-orange-400 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fas fa-bell"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Smart Alerts</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Automated notifications for maintenance schedules and urgent sanitation requirements.
                </p>
            </div>
            
            <div class="premium-card p-8 animate-fade-in-up group" style="animation-delay: 0.4s">
                <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Role Management</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Granular access control with admin, staff, and user roles for secure operations.
                </p>
            </div>
            
            <div class="premium-card p-8 animate-fade-in-up group" style="animation-delay: 0.5s">
                <div class="w-14 h-14 rounded-2xl bg-rose-100 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Mobile Friendly</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Responsive design ensures seamless access across all devices and screen sizes.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="architecture" class="py-24 bg-slate-900 dark:bg-slate-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=2500')] opacity-5 mix-blend-overlay bg-cover bg-center"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <h2 class="text-4xl font-extrabold mb-6 tracking-tight">Three-Tier Architecture</h2>
            <p class="text-lg text-slate-400">
                Designed for scalability, maximum security, and high operational efficiency across all levels.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-slate-800/40 backdrop-blur-3xl rounded-[2.5rem] p-10 border-[3px] border-slate-700/40 hover:bg-slate-800/60 transition-all animate-fade-in-up text-center shadow-2xl">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center mx-auto mb-8 shadow-lg shadow-red-500/30">
                    <i class="fas fa-user-shield text-3xl"></i>
                </div>
                <h3 class="text-2xl font-black mb-4 uppercase tracking-tighter">Administration</h3>
                <p class="text-slate-400 mb-8 text-sm leading-relaxed font-medium">
                    Complete oversight with precise facility management, automatic task assignment, and high-level analytics.
                </p>
                <ul class="text-left text-[11px] text-slate-300 space-y-4 inline-block font-black uppercase tracking-widest">
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Facility Blueprinting</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Task Assignment</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Staff Management</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Compliance Monitoring</li>
                </ul>
            </div>
            
            <div class="bg-slate-800/40 backdrop-blur-3xl rounded-[2.5rem] p-10 border-[3px] border-slate-700/40 hover:bg-slate-800/60 transition-all animate-fade-in-up text-center shadow-2xl" style="animation-delay: 0.1s">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center mx-auto mb-8 shadow-lg shadow-primary-500/30">
                    <i class="fas fa-hard-hat text-3xl"></i>
                </div>
                <h3 class="text-2xl font-black mb-4 uppercase tracking-tighter">Operations Staff</h3>
                <p class="text-slate-400 mb-8 text-sm leading-relaxed font-medium">
                    Streamlined workflow dashboard optimized for fulfilling daily tasks and systematic maintenance.
                </p>
                <ul class="text-left text-[11px] text-slate-300 space-y-4 inline-block font-black uppercase tracking-widest">
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Live Task Dashboard</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Print Manifests</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Status Updates</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Fast Mobile Access</li>
                </ul>
            </div>
            
            <div class="bg-slate-800/40 backdrop-blur-3xl rounded-[2.5rem] p-10 border-[3px] border-slate-700/40 hover:bg-slate-800/60 transition-all animate-fade-in-up text-center shadow-2xl" style="animation-delay: 0.2s">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center mx-auto mb-8 shadow-lg shadow-emerald-500/30">
                    <i class="fas fa-users text-3xl"></i>
                </div>
                <h3 class="text-2xl font-black mb-4 uppercase tracking-tighter">Public Users</h3>
                <p class="text-slate-400 mb-8 text-sm leading-relaxed font-medium">
                    Intuitive interface prioritizing swift complaint reporting and tracking for hospital guests and patients.
                </p>
                <ul class="text-left text-[11px] text-slate-300 space-y-4 inline-block font-black uppercase tracking-widest">
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Facility Information</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Complaint Reporting</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Transparent Tracking</li>
                    <li class="flex items-center"><i class="fas fa-check-circle text-emerald-400 mr-3"></i> Public Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="py-24">
    <div class="container mx-auto px-6 text-center">
        <div class="premium-card p-12 max-w-4xl mx-auto bg-gradient-to-br from-white/90 to-slate-50/80 dark:from-slate-800/90 dark:to-slate-900/80 border-[3px] border-indigo-500/30 backdrop-blur-3xl shadow-3xl">
            <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-6">
                Ready to Transform Your Facility Management?
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg mb-8 max-w-2xl mx-auto">
                Join hundreds of elite healthcare facilities already using WMS for optimal, trackable hygiene management.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if(auth()->check())
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isStaff() ? route('staff.dashboard') : route('dashboard')) }}" class="btn-primary px-10 py-4 text-lg w-full sm:w-auto">
                        <i class="fas fa-rocket mr-2"></i> Launch Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary px-10 py-4 text-lg w-full sm:w-auto">
                        <i class="fas fa-rocket mr-2"></i> Get Started Free
                    </a>
                    <a href="#" class="btn-secondary px-10 py-4 text-lg w-full sm:w-auto">
                        <i class="fas fa-envelope mr-2"></i> Contact Sales
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

