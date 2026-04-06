@extends('layouts.app')

@section('title', 'Identity Management | Professional Profile')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    
    
    <div class="premium-card p-10 mb-10 shadow-sm animate-fade-in-up">
        <div class="flex flex-col md:flex-row items-center gap-10">
            
            <div class="relative group">
                <div class="w-36 h-36 rounded-full border-4 border-slate-100 dark:border-slate-800 overflow-hidden bg-slate-50 dark:bg-slate-800 flex items-center justify-center shadow-inner">
                    @if(auth()->user()->profile_photo)
                        <img id="avatar-preview" src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <div id="avatar-placeholder" class="text-5xl font-black text-indigo-500 uppercase">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data" class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/40 rounded-full cursor-pointer">
                    @csrf
                    <label for="photo" class="cursor-pointer text-white flex flex-col items-center">
                        <i class="fas fa-camera text-2xl mb-1"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Upload</span>
                    </label>
                    <input type="file" name="photo" id="photo" class="hidden" onchange="previewImage(this); this.form.submit();">
                </form>
            </div>
            
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-4">
                    <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tighter uppercase" data-sync-field="user-name">{{ auth()->user()->name }}</h1>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-black text-xs uppercase tracking-widest hover:bg-slate-900 dark:hover:bg-white hover:text-white dark:hover:text-slate-900 transition-all border-2 border-slate-200 dark:border-slate-700 shadow-sm">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                    <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-600 text-white shadow-lg">
                        {{ auth()->user()->role }}
                    </span>
                    <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-[0.2em] bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                        ID: {{ substr(auth()->user()->_id, -8) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-5 bg-emerald-50 dark:bg-emerald-500/10 border-2 border-emerald-500/20 rounded-2xl flex items-center gap-4 text-emerald-600 dark:text-emerald-400">
            <i class="fas fa-check-circle text-xl"></i>
            <p class="text-sm font-bold uppercase tracking-widest">{{ session('success') }}</p>
        </div>
    @endif

    <div class="space-y-10">
        
        
        <div class="premium-card p-10 shadow-sm animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="flex items-center gap-4 mb-10 pb-6 border-b border-slate-100 dark:border-slate-800">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-lg">
                    <i class="fas fa-user-gear"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Personal Information</h3>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8" data-ajax-form>
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                        <div class="input-group-tactical">
                            <div class="icon-box-tactical">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                   class="tactical-input w-full !bg-slate-50/50 dark:!bg-slate-950/50 !border-2">
                        </div>
                        @error('name') <p class="text-[10px] text-rose-500 font-bold uppercase ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                        <div class="input-group-tactical">
                            <div class="icon-box-tactical">
                                <i class="fas fa-phone-volume"></i>
                            </div>
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                                   class="tactical-input w-full !bg-slate-50/50 dark:!bg-slate-950/50 !border-2">
                        </div>
                        @error('phone') <p class="text-[10px] text-rose-500 font-bold uppercase ml-1 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">HQ Address</label>
                    <div class="input-group-tactical">
                        <div class="icon-box-tactical h-auto min-h-[4rem]">
                            <i class="fas fa-map-location-dot"></i>
                        </div>
                        <textarea name="address" rows="3" required
                                  class="tactical-input w-full !bg-slate-50/50 dark:!bg-slate-950/50 !border-2 leading-relaxed">{{ old('address', auth()->user()->address) }}</textarea>
                    </div>
                    @error('address') <p class="text-[10px] text-rose-500 font-bold uppercase ml-1 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="btn-primary px-12 py-4">Update Profile</button>
                </div>
            </form>
        </div>

        
        <div class="premium-card p-10 shadow-sm animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="flex items-center justify-between mb-10 pb-6 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Email Synchronization</h3>
                </div>
                
                <div id="email-status-indicator" data-sync-field="email-status-indicator">
                    @if(session('verification_dispatched'))
                        <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-500/10 border-2 border-emerald-500/30 animate-pulse">
                            <i class="fas fa-paper-plane text-emerald-500"></i>
                            <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest leading-none">Link Sent</span>
                        </div>
                    @elseif(auth()->user()->email_verified_at)
                        <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border-2 border-emerald-500/20">
                            <i class="fas fa-certificate text-emerald-500 animate-pulse"></i>
                            <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest leading-none">Verified</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-50 dark:bg-rose-500/10 border-2 border-rose-500/20">
                            <i class="fas fa-circle-exclamation text-rose-500 animate-pulse"></i>
                            <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest leading-none">Not Verified</span>
                        </div>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border-2 border-emerald-500/20 animate-fade-in">
                    <p class="text-xs font-black text-emerald-500 uppercase tracking-widest">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </p>
                </div>
            @endif

            <form action="{{ route('profile.email') }}" method="POST" class="space-y-8" data-ajax-form>
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Intelligence Uplink Address</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                               class="tactical-input w-full !bg-slate-50/50 dark:!bg-slate-950/50 !border-2">
                    </div>

                    <div id="email-action-area" data-sync-field="email-action-area">
                        @if(session('verification_dispatched'))
                            <div class="p-6 bg-emerald-500/10 rounded-2xl border-2 border-emerald-500/30 animate-zoom-in">
                                <h5 class="text-sm font-black text-emerald-500 uppercase tracking-tighter mb-1">
                                    <i class="fas fa-check-circle mr-2"></i> Verification Protocol Initiated
                                </h5>
                                <p class="text-[10px] font-bold text-emerald-600/80 dark:text-emerald-400/80 uppercase tracking-widest leading-relaxed">
                                    A synchronization link has been sent to your new email. Please verify and re-authenticate to restore full node access.
                                </p>
                            </div>
                        @elseif(!auth()->user()->email_verified_at)
                            <div class="p-5 bg-rose-500/5 dark:bg-rose-500/10 rounded-2xl border-2 border-rose-500/20">
                                <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest leading-relaxed">
                                    <i class="fas fa-triangle-exclamation mr-2"></i> Account status: Unverified. Limited access protocols enabled. Verify to continue using full features.
                                </p>
                            </div>
                        @else
                            <div class="p-5 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border-2 border-slate-100 dark:border-slate-800">
                                <p class="text-[10px] font-black text-slate-500 dark:text-indigo-300 uppercase tracking-widest leading-relaxed">
                                    <i class="fas fa-shield-virus mr-2"></i> Updating this signal uplink will require a full verification cycle and session reset.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-4" data-sync-field="email-footer-area">
                    @if(!auth()->user()->email_verified_at)
                        <button type="button" onclick="document.getElementById('resend-form').submit();" 
                                class="text-[10px] font-black text-indigo-500 hover:text-indigo-600 uppercase tracking-widest underline decoration-2 underline-offset-4 transition-all">
                            <i class="fas fa-rotate mr-2"></i> Resend Verification Link
                        </button>
                    @else
                        <div></div>
                    @endif
                    <button type="submit" class="btn-primary bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 px-12 py-4">Update Intelligence Uplink</button>
                </div>
            </form>

            <form id="resend-form" action="{{ route('profile.resend') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>

        
        <div class="premium-card p-10 shadow-sm animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="flex items-center gap-4 mb-10 pb-6 border-b border-slate-100 dark:border-slate-800">
                <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center text-lg">
                    <i class="fas fa-lock"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Security Protocols</h3>
            </div>

            <form action="{{ route('profile.password') }}" method="POST" class="space-y-8" data-ajax-form>
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Current Validation Key</label>
                    <div class="relative group/pw">
                        <input type="password" name="current_password" id="current_password" required
                               class="tactical-input w-full !bg-slate-50/50 dark:!bg-slate-950/50 !border-2 pr-12">
                        <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500 transition-colors">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('current_password') <p class="text-[10px] text-rose-500 font-bold uppercase ml-1 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div class="space-y-2 text-left">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Validation Key</label>
                            <div class="relative group/pw">
                                <input type="password" name="password" id="new_pw" required
                                       oninput="evaluateStrength(this.value)"
                                       class="tactical-input w-full !bg-slate-50/50 dark:!bg-slate-950/50 !border-2 pr-12">
                                <button type="button" onclick="togglePassword('new_pw', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500 transition-colors">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>
                        
                        
                        <div class="space-y-2">
                             <div class="flex items-center justify-between px-1">
                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Tactical Strength</span>
                                <span id="strength-label" class="text-[9px] font-black uppercase tracking-widest text-slate-400">Zero</span>
                             </div>
                             <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden flex gap-1">
                                <div id="bar-1" class="h-full flex-1 transition-all duration-500 bg-slate-200 dark:bg-slate-700"></div>
                                <div id="bar-2" class="h-full flex-1 transition-all duration-500 bg-slate-200 dark:bg-slate-700"></div>
                                <div id="bar-3" class="h-full flex-1 transition-all duration-500 bg-slate-200 dark:bg-slate-700"></div>
                             </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm Secret Handshake</label>
                        <div class="relative group/pw">
                            <input type="password" name="password_confirmation" id="confirm_pw" required
                                   oninput="checkMatch()"
                                   class="tactical-input w-full !bg-slate-50/50 dark:!bg-slate-950/50 !border-2 pr-12">
                            <button type="button" onclick="togglePassword('confirm_pw', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500 transition-colors">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                        <p id="match-error" class="text-[9px] font-black text-rose-500 uppercase ml-1 mt-2 hidden tracking-widest">
                            <i class="fas fa-circle-exclamation mr-1"></i> Keys do not match
                        </p>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" id="pw-btn" class="btn-primary bg-rose-600 hover:bg-rose-700 border-rose-500/50 px-12 py-4">Save Password</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');
                if (preview) preview.src = e.target.result;
                else if (placeholder) {
                    placeholder.classList.add('hidden');
                    const img = document.createElement('img');
                    img.id = 'avatar-preview';
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover rounded-full';
                    placeholder.parentNode.appendChild(img);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function evaluateStrength(pw) {
        const label = document.getElementById('strength-label');
        const bar1 = document.getElementById('bar-1');
        const bar2 = document.getElementById('bar-2');
        const bar3 = document.getElementById('bar-3');
        
        let strength = 0;
        
        if (pw.length > 0) {
            if (pw.length < 6) {
                strength = 1; // Weak
            } else {
                const hasLetters = /[a-zA-Z]/.test(pw);
                const hasNumbers = /[0-9]/.test(pw);
                const hasUpper = /[A-Z]/.test(pw);
                const hasLower = /[a-z]/.test(pw);
                const hasSpecial = /[^A-Za-z0-9]/.test(pw);

                if (hasLetters && hasNumbers) {
                    if (hasUpper && hasLower && hasSpecial) {
                        strength = 3; // Strong
                    } else {
                        strength = 2; // Medium
                    }
                } else {
                    strength = 1; // Still Weak if just letters or just numbers
                }
            }
        }

        [bar1, bar2, bar3].forEach(b => {
             b.className = 'h-full flex-1 transition-all duration-500 bg-slate-200 dark:bg-slate-800';
        });
        label.className = 'text-[9px] font-black uppercase tracking-widest text-slate-400';

        if (strength === 1) {
            bar1.classList.remove('bg-slate-200', 'dark:bg-slate-800');
            bar1.classList.add('bg-rose-500');
            label.innerText = 'Weak';
            label.classList.remove('text-slate-400');
            label.classList.add('text-rose-500');
        } else if (strength === 2) {
            [bar1, bar2].forEach(b => {
                b.classList.remove('bg-slate-200', 'dark:bg-slate-800');
                b.classList.add('bg-amber-500');
            });
            label.innerText = 'Medium';
            label.classList.remove('text-slate-400');
            label.classList.add('text-amber-500');
        } else if (strength === 3) {
            [bar1, bar2, bar3].forEach(b => {
                b.classList.remove('bg-slate-200', 'dark:bg-slate-800');
                b.classList.add('bg-emerald-500');
            });
            label.innerText = 'Strong';
            label.classList.remove('text-slate-400');
            label.classList.add('text-emerald-500');
        } else {
            label.innerText = 'Zero';
        }
    }

    function checkMatch() {
        const pw = document.getElementById('new_pw').value;
        const confirm = document.getElementById('confirm_pw').value;
        const error = document.getElementById('match-error');
        const btn = document.getElementById('pw-btn');

        if (confirm && pw !== confirm) {
            error.classList.remove('hidden');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'pointer-events-none');
        } else {
            error.classList.add('hidden');
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'pointer-events-none');
        }
    }
</script>
@endsection

