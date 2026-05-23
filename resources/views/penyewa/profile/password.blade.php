<div class="mb-8">
    <h3 class="text-lg font-bold text-slate-900 mb-1">Keamanan Akun</h3>
    <p class="text-sm text-slate-400">Perbarui kata sandi Anda secara berkala</p>
</div>

<div class="max-w-md" x-data="{ showOld: false, showNew: false, showConfirm: false }">

    @if($errors->has('current_password'))
        <div class="mb-5 p-4 rounded-xl flex items-center gap-3 bg-red-50 text-red-600 border border-red-100">
            <i class="fas fa-exclamation-circle text-sm"></i>
            <p class="text-sm font-semibold">{{ $errors->first('current_password') }}</p>
        </div>
    @endif
    @if($errors->has('new_password'))
        <div class="mb-5 p-4 rounded-xl flex items-center gap-3 bg-red-50 text-red-600 border border-red-100">
            <i class="fas fa-exclamation-circle text-sm"></i>
            <p class="text-sm font-semibold">{{ $errors->first('new_password') }}</p>
        </div>
    @endif

    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kata Sandi Saat Ini</label>
            <div class="relative">
                <input :type="showOld ? 'text' : 'password'" name="current_password" required placeholder="••••••••"
                    class="w-full px-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all">
                <button type="button" @click="showOld = !showOld"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 hover:text-slate-500 transition-colors">
                    <i class="fas text-sm" :class="showOld ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
        </div>

        <div class="pt-2">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-px flex-1 bg-slate-100"></div>
                <span class="text-[10px] font-semibold text-slate-300 uppercase tracking-widest">Sandi Baru</span>
                <div class="h-px flex-1 bg-slate-100"></div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kata Sandi Baru</label>
                    <div class="relative">
                        <input :type="showNew ? 'text' : 'password'" name="new_password" required placeholder="Min. 8 karakter"
                            class="w-full px-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all">
                        <button type="button" @click="showNew = !showNew"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 hover:text-slate-500 transition-colors">
                            <i class="fas text-sm" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" name="new_password_confirmation" required placeholder="Ulangi kata sandi baru"
                            class="w-full px-4 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all">
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 hover:text-slate-500 transition-colors">
                            <i class="fas text-sm" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-start gap-3">
            <i class="fas fa-shield-halved text-slate-400 text-sm mt-0.5"></i>
            <p class="text-xs text-slate-500 leading-relaxed">Gunakan minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, dan angka.</p>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="px-8 py-3 bg-slate-900 text-white text-sm font-semibold rounded-xl hover:bg-primary transition-all duration-200 shadow-md active:scale-95">
                Perbarui Kata Sandi
            </button>
        </div>
    </form>
</div>
