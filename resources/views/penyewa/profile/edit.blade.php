<div class="mb-8">
    <h3 class="text-lg font-bold text-slate-900 mb-1">Edit Profile</h3>
    <p class="text-sm text-slate-400">Perbarui informasi profil Anda</p>
</div>

<form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
    @csrf

    <div>
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Identitas Terverifikasi</p>
            @if ($user->is_verified === 'verified')
                <span
                    class="text-[10px] font-semibold px-2 py-1 bg-emerald-50 text-emerald-600 rounded-md border border-emerald-100">
                    <i class="fas fa-check-circle mr-1"></i>Verified
                </span>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5 bg-slate-50 rounded-xl border border-slate-200">
            @foreach ([['label' => 'Nama Lengkap (KTP)', 'value' => $user->full_name_ktp ?: 'Belum verifikasi'], ['label' => 'Jenis Kelamin', 'value' => $user->gender ?: '-'], ['label' => 'Tanggal Lahir', 'value' => $user->birth_date && $user->birth_date != '0000-00-00' ? \Carbon\Carbon::parse($user->birth_date)->translatedFormat('d M Y') : '-'], ['label' => 'Email', 'value' => $user->email]] as $field)
                <div>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1.5">
                        {{ $field['label'] }}</p>
                    <p
                        class="text-sm font-semibold text-slate-400 bg-white border border-slate-200 rounded-lg px-4 py-2.5">
                        {{ $field['value'] }}</p>
                </div>
            @endforeach
            <div class="md:col-span-2 pt-3 border-t border-slate-200">
                <p class="text-[11px] text-slate-400 flex items-center gap-2">
                    <i class="fas fa-shield-halved text-slate-300"></i>
                    Data terkunci demi keamanan. Hubungi Admin untuk perubahan.
                </p>
            </div>
        </div>
    </div>

    <div>
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">Informasi Kontak</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nama Panggilan</label>
                <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}" required
                    placeholder="Nama panggilan..."
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all
                    @error('nickname') border-red-300 @enderror">
                @error('nickname')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nomor WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                    placeholder="08123456789"
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all
                    @error('phone') border-red-300 @enderror">
                @error('phone')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Alamat Asal</label>
                <textarea name="address" rows="3" required placeholder="Alamat lengkap..."
                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all resize-none
                    @error('address') border-red-300 @enderror">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="pt-4 border-t border-slate-100">
        <button type="submit"
            class="w-full md:w-auto px-8 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all duration-200 shadow-md shadow-primary/20 active:scale-95 min-h-[44px]">
            Simpan Perubahan
        </button>
    </div>
</form>
