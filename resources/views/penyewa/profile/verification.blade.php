<div class="mb-8">
    <h3 class="text-lg font-bold text-slate-900 mb-1">Verifikasi Identitas</h3>
    <p class="text-sm text-slate-400">Lengkapi data KTP untuk mengaktifkan fitur pemesanan kamar</p>
</div>

<div class="space-y-6">

    @if ($user->is_verified === 'verified')
        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-8 text-center">
            <div
                class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-emerald-500 shadow-sm mx-auto mb-4 border border-emerald-100">
                <i class="fas fa-check-double text-xl"></i>
            </div>
            <h4 class="text-base font-bold text-emerald-800 mb-1">Akun Terverifikasi</h4>
            <p class="text-sm text-emerald-600/80 mb-6 max-w-sm mx-auto">
                Identitas Anda telah dikonfirmasi. Sekarang Anda dapat memesan kamar di Griya Asri Kos.
            </p>
            <a href="{{ route('penyewa.dashboard') }}"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-500 text-white text-sm font-semibold rounded-xl hover:bg-emerald-600 transition-all shadow-md shadow-emerald-200">
                <i class="fas fa-home text-xs"></i>
                Mulai Booking
            </a>
        </div>
    @elseif($user->is_verified === 'pending')
        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6 flex items-center gap-4">
            <div
                class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-amber-500 shadow-sm border border-amber-100 flex-shrink-0">
                <i class="fas fa-clock text-base animate-pulse"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">Sedang Ditinjau</p>
                <p class="text-xs text-slate-500 mt-0.5">Proses verifikasi memakan waktu 1–24 jam. Kami akan memberitahu
                    Anda setelah selesai.</p>
            </div>
        </div>
    @else
        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 flex items-center gap-3 mb-2">
            <i class="fas fa-exclamation-triangle text-amber-500 text-sm flex-shrink-0"></i>
            <p class="text-xs font-semibold text-slate-600">Lengkapi formulir berikut untuk memverifikasi identitas
                Anda.</p>
        </div>

        <form action="{{ route('profile.verify') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">Data Diri</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nama Lengkap (Sesuai
                            KTP)</label>
                        <input type="text" name="full_name_ktp" value="{{ old('full_name_ktp') }}" required
                            placeholder="Contoh: Muhammad Raynar Hammam"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all
                            @error('full_name_ktp') border-red-300 @enderror">
                        @error('full_name_ktp')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Tanggal Lahir</label>
                        <div class="relative">
                            <input type="text" id="birthDateDisplay" placeholder="Pilih tanggal lahir" readonly
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all cursor-pointer
                                @error('birth_date') border-red-300 @enderror">
                            <input type="hidden" name="birth_date" id="birthDateHidden"
                                value="{{ old('birth_date') }}">
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i class="fas fa-calendar-alt text-xs"></i>
                            </div>
                        </div>
                        @error('birth_date')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Jenis Kelamin</label>
                        <div class="relative">
                            <select name="gender" id="genderSelect" required
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all appearance-none cursor-pointer
                                @error('gender') border-red-300 @enderror">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <i class="fas fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                        @error('gender')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Alamat Lengkap</label>
                        <textarea name="address" required rows="3" placeholder="Alamat lengkap sesuai domisili saat ini..."
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all resize-none
                            @error('address') border-red-300 @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">Dokumen Identitas</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-data="{ ktpPreview: null, selfiePreview: null }">

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Foto KTP / Kartu
                            Identitas</label>
                        <div
                            class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl text-center group hover:border-primary transition-all relative min-h-[140px] flex items-center justify-center overflow-hidden cursor-pointer">
                            <input type="file" name="ktp_photo" id="ktpUpload" class="hidden" accept="image/*"
                                required
                                x-on:change="ktpPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                            <label for="ktpUpload" class="cursor-pointer block w-full h-full p-6">
                                <template x-if="!ktpPreview">
                                    <div class="space-y-2">
                                        <i
                                            class="fas fa-id-card text-xl text-slate-300 group-hover:text-primary transition-colors"></i>
                                        <p class="text-xs font-semibold text-slate-400">Pilih Berkas</p>
                                    </div>
                                </template>
                                <template x-if="ktpPreview">
                                    <img :src="ktpPreview"
                                        class="w-full max-h-[120px] object-cover rounded-lg shadow-sm">
                                </template>
                            </label>
                        </div>
                        @error('ktp_photo')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Foto Selfie Dengan KTP</label>
                        <div
                            class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl text-center group hover:border-primary transition-all relative min-h-[140px] flex items-center justify-center overflow-hidden cursor-pointer">
                            <input type="file" name="selfie_photo" id="selfieUpload" class="hidden" accept="image/*"
                                required
                                x-on:change="selfiePreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                            <label for="selfieUpload" class="cursor-pointer block w-full h-full p-6">
                                <template x-if="!selfiePreview">
                                    <div class="space-y-2">
                                        <i
                                            class="fas fa-camera text-xl text-slate-300 group-hover:text-primary transition-colors"></i>
                                        <p class="text-xs font-semibold text-slate-400">Pilih Berkas</p>
                                    </div>
                                </template>
                                <template x-if="selfiePreview">
                                    <img :src="selfiePreview"
                                        class="w-full max-h-[120px] object-cover rounded-lg shadow-sm">
                                </template>
                            </label>
                        </div>
                        @error('selfie_photo')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-3 flex items-center gap-1.5">
                    <i class="fas fa-shield-halved text-slate-300"></i>
                    Data Anda dienkripsi dan hanya digunakan untuk keperluan verifikasi.
                </p>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <button type="submit"
                    class="px-8 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all duration-200 shadow-md shadow-primary/20 active:scale-95">
                    Simpan & Verifikasi Identitas
                </button>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const hiddenInput = document.getElementById('birthDateHidden');
                const oldValue = hiddenInput.value;

                flatpickr('#birthDateDisplay', {
                    dateFormat: 'Y-m-d',
                    maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 15)),
                    defaultDate: oldValue || null,
                    disableMobile: true,
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                            longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                        },
                        months: {
                            shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                                'Nov', 'Des'
                            ],
                            longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                                'Agustus', 'September', 'Oktober', 'November', 'Desember'
                            ],
                        },
                    },
                    onChange: function(selectedDates, dateStr) {
                        hiddenInput.value = dateStr;
                        document.getElementById('birthDateDisplay').style.color = '#1e293b';
                    },
                    onReady: function(selectedDates, dateStr, instance) {
                        if (!oldValue) {
                            document.getElementById('birthDateDisplay').style.color = '#94a3b8';
                        }
                    }
                });

                const sel = document.getElementById('genderSelect');

                function updateSelectColor() {
                    sel.style.color = sel.value === '' ? '#94a3b8' : '#1e293b';
                }
                sel.addEventListener('change', updateSelectColor);
                updateSelectColor();
            });
        </script>
    @endif
</div>
