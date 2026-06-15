@extends('penyewa.layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen">

        <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-8 pb-4">
            <a href="{{ route('home') }}#daftar-kamar"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Kamar
            </a>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 pb-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-5">

                    <div class="relative rounded-2xl overflow-hidden h-[420px] bg-slate-200 group shadow-sm">
                        <img src="{{ asset('images/room_types/' . $room->roomType->image) }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            alt="Interior Kamar {{ $room->room_number }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent">
                        </div>
                        <div class="absolute top-4 left-4 flex gap-2">
                            <span
                                class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-lg text-slate-700 font-semibold text-xs shadow-sm">
                                {{ $room->roomType->name }}
                            </span>
                            <span
                                class="px-3 py-1.5 rounded-lg font-semibold text-xs text-white shadow-sm
                            {{ $room->gender_type == 'Putra' ? 'bg-primary' : 'bg-pink-500' }}">
                                {{ $room->gender_type }}
                            </span>
                        </div>
                        <div class="absolute bottom-4 left-4">
                            <h1 class="text-2xl font-black text-white tracking-tight drop-shadow">
                                Kamar {{ $room->room_number }}
                            </h1>
                            <div class="flex items-center gap-1.5 mt-1">
                                <i class="fas fa-star text-amber-400 text-xs"></i>
                                <span class="text-white font-semibold text-sm">{{ $room->rating }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <p class="text-slate-500 leading-relaxed text-sm italic">
                            "{{ $room->roomType->description }}"
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-base font-bold text-slate-900 mb-5 flex items-center gap-2">
                            <span class="w-1 h-4 bg-primary rounded-full inline-block"></span>
                            Fasilitas Kamar
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @php $facilities = explode(',', $room->facilities); @endphp
                            @foreach ($facilities as $item)
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-5 h-5 bg-primary/10 rounded-md flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-check text-[9px] text-primary"></i>
                                    </div>
                                    <span class="text-sm font-medium text-slate-600">{{ trim($item) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-base font-bold text-slate-900 mb-5 flex items-center gap-2">
                            <span class="w-1 h-4 bg-slate-900 rounded-full inline-block"></span>
                            Spesifikasi
                        </h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div
                                    class="w-9 h-9 bg-white rounded-lg border border-slate-200 flex items-center justify-center text-slate-600 flex-shrink-0">
                                    <i class="fas fa-vector-square text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Luas</p>
                                    <p class="text-sm font-bold text-slate-800">{{ $room->area_size }} m²</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div
                                    class="w-9 h-9 bg-white rounded-lg border border-slate-200 flex items-center justify-center text-amber-500 flex-shrink-0">
                                    <i class="fas fa-bolt text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Listrik
                                    </p>
                                    <p class="text-sm font-bold text-slate-800">
                                        {{ $room->is_electric_included ? 'Include' : 'Token' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div
                                    class="w-9 h-9 bg-white rounded-lg border border-slate-200 flex items-center justify-center text-blue-400 flex-shrink-0">
                                    <i class="fas fa-tint text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest">Air</p>
                                    <p class="text-sm font-bold text-slate-800">
                                        {{ $room->is_water_included ? 'Gratis' : 'Bayar' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-base font-bold text-slate-900 mb-5 flex items-center gap-2">
                            <span class="w-1 h-4 bg-emerald-500 rounded-full inline-block"></span>
                            Informasi Harga
                        </h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-center">
                                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1.5">Harian
                                </p>
                                <p class="text-base font-black text-slate-900">Rp
                                    {{ number_format($room->roomType->base_price_daily, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-center">
                                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1.5">
                                    Mingguan</p>
                                <p class="text-base font-black text-slate-900">Rp
                                    {{ number_format($room->roomType->base_price_weekly, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-4 bg-primary/5 rounded-xl border border-primary/10 text-center">
                                <p class="text-[10px] font-semibold text-primary/60 uppercase tracking-widest mb-1.5">
                                    Bulanan</p>
                                <p class="text-base font-black text-primary">Rp
                                    {{ number_format($room->roomType->base_price_monthly, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-base font-bold text-slate-900 mb-5 flex items-center gap-2">
                            <span class="w-1 h-4 bg-red-400 rounded-full inline-block"></span>
                            Peraturan Kamar
                        </h3>
                        <div class="bg-red-50 border border-red-100 rounded-xl p-5">
                            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $room->room_rules }}
                            </p>
                        </div>
                        <p class="mt-3 text-[11px] text-slate-400 flex items-center gap-1.5">
                            <i class="fas fa-info-circle text-slate-300"></i>
                            Pelanggaran dapat dikenakan sanksi sesuai kebijakan owner.
                        </p>
                    </div>

                </div>

                <div>
                    <div
                        class="bg-white rounded-2xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6 sticky top-20">

                        <form id="formPesan" action="{{ route('transactions.confirm') }}" method="POST">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <input type="hidden" name="check_in" id="inputCheckIn">
                            <input type="hidden" name="check_out" id="inputCheckOut">
                            <input type="hidden" name="total_price" id="inputTotal" value="0">

                            <h3 class="text-base font-bold text-slate-900 mb-5">Pesan Kamar Ini</h3>

                            <div class="space-y-3 mb-4">
                                <div>
                                    <label
                                        class="block text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1.5">Tanggal
                                        Mulai</label>
                                    <input type="text" id="tglMulai" readonly
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none cursor-pointer transition-all">
                                    @error('check_in')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label
                                        class="block text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1.5">Tanggal
                                        Selesai</label>
                                    <input type="text" id="tglSelesai" readonly
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 text-sm font-semibold text-slate-700 placeholder:text-slate-400 focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none cursor-pointer transition-all">
                                    @error('check_out')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="flex justify-between items-center bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl mb-4">
                                <span class="text-sm font-semibold text-slate-500">Durasi Sewa</span>
                                <span id="textDurasi" class="text-sm font-bold text-slate-900">0 Hari</span>
                            </div>

                            <div class="border-t border-slate-100 pt-4 mb-4">
                                <h4 class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-3">Layanan
                                    Tambahan</h4>
                                <div class="space-y-1">
                                    @foreach ($services as $service)
                                        <div
                                            class="service-item flex items-center gap-3 p-2.5 rounded-lg hover:bg-slate-50 transition-colors cursor-pointer">
                                            <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                                class="service-checkbox w-4 h-4 rounded text-primary accent-primary"
                                                data-id="{{ $service->id }}" data-name="{{ $service->service_name }}"
                                                data-price="{{ $service->service_price }}"
                                                data-type="{{ strtolower($service->duration_type) }}"
                                                onchange="hitungTotal()">
                                            <label class="flex-1 cursor-pointer">
                                                <span
                                                    class="block text-sm font-semibold text-slate-700">{{ $service->service_name }}</span>
                                                <span class="text-[11px] text-slate-400">Rp
                                                    {{ number_format($service->service_price, 0, ',', '.') }} /
                                                    {{ $service->duration_type }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="mt-2 text-[11px] text-slate-400 italic">*Layanan mingguan aktif minimal 7 hari
                                    sewa.</p>
                            </div>

                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-4 mb-5">
                                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1">Estimasi
                                    Total</p>
                                <div class="flex items-baseline justify-between">
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-sm font-bold text-slate-500">Rp</span>
                                        <span id="textTotal" class="text-2xl font-black text-slate-900">0</span>
                                    </div>
                                    <span
                                        class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-1 rounded-lg">
                                        <i class="fas fa-shield-alt mr-1"></i>Aman
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                @guest
                                    <a href="{{ route('login') }}"
                                        class="w-full bg-slate-900 hover:bg-black text-white font-semibold py-3.5 rounded-xl transition-all flex items-center justify-center gap-2 text-sm">
                                        <i class="fas fa-sign-in-alt"></i> Login untuk Memesan
                                    </a>
                                @else
                                    @if (auth()->user()->is_verified !== 'verified')
                                        <a href="{{ route('profile', ['tab' => 'verification']) }}"
                                            class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3.5 rounded-xl transition-all flex items-center justify-center gap-2 text-sm">
                                            <i class="fas fa-id-card"></i> Verifikasi Akun dulu
                                        </a>
                                        <p
                                            class="text-[11px] text-amber-600 bg-amber-50 border border-amber-100 rounded-lg p-3 text-center leading-relaxed">
                                            Lengkapi data KTP sebelum memesan kamar.
                                        </p>
                                    @elseif($room->status !== 'available')
                                        <button disabled
                                            class="w-full bg-slate-100 text-slate-400 font-semibold py-3.5 rounded-xl cursor-not-allowed flex items-center justify-center gap-2 text-sm">
                                            <i class="fas fa-ban"></i> Kamar Tidak Tersedia
                                        </button>
                                    @else
                                        <button type="submit" id="btnPesan" disabled
                                            class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3.5 rounded-xl shadow-md shadow-primary/20 transition-all flex items-center justify-center gap-2 text-sm disabled:opacity-40 disabled:cursor-not-allowed">
                                            <i class="fas fa-calendar-check"></i> Pesan Sekarang
                                        </button>
                                    @endif
                                @endguest

                                <a href="https://wa.me/6289502390206" target="_blank"
                                    class="w-full flex items-center justify-center gap-2 border border-slate-200 text-slate-600 font-semibold py-3.5 rounded-xl hover:bg-slate-50 transition-all text-sm">
                                    <i class="fab fa-whatsapp text-emerald-500"></i> Hubungi Owner
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const daily = {{ (int) $room->roomType->base_price_daily }};
        const weekly = {{ (int) $room->roomType->base_price_weekly }};
        const monthly = {{ (int) $room->roomType->base_price_monthly }};

        function hitungTotal() {
            const tgl1 = document.getElementById('tglMulai').value;
            const tgl2 = document.getElementById('tglSelesai').value;
            const displayTotal = document.getElementById('textTotal');
            const inputTotal = document.getElementById('inputTotal');
            const inputCheckIn = document.getElementById('inputCheckIn');
            const inputCheckOut = document.getElementById('inputCheckOut');
            const displayDurasi = document.getElementById('textDurasi');
            const btn = document.getElementById('btnPesan');

            if (tgl1 && tgl2) {
                const diffDays = Math.round((new Date(tgl2) - new Date(tgl1)) / 86400000);

                if (diffDays > 0) {
                    document.querySelectorAll('.service-checkbox').forEach(cb => {
                        const isWeekly = cb.getAttribute('data-type').includes('minggu');
                        const parentDiv = cb.closest('.service-item');
                        if (isWeekly && diffDays < 7) {
                            cb.checked = false;
                            cb.disabled = true;
                            if (parentDiv) parentDiv.style.opacity = '0.4';
                        } else {
                            cb.disabled = false;
                            if (parentDiv) parentDiv.style.opacity = '1';
                        }
                    });

                    let hargaKamar = 0;
                    if (diffDays >= 30) hargaKamar = Math.floor(diffDays / 30) * monthly + (diffDays % 30) * daily;
                    else if (diffDays >= 7) hargaKamar = Math.floor(diffDays / 7) * weekly + (diffDays % 7) * daily;
                    else hargaKamar = diffDays * daily;

                    let totalService = 0;
                    document.querySelectorAll('.service-checkbox').forEach(cb => {
                        if (cb.checked && !cb.disabled) {
                            const price = Number(cb.getAttribute('data-price'));
                            totalService += cb.getAttribute('data-type').includes('minggu') ?
                                price * Math.floor(diffDays / 7) :
                                price * diffDays;
                        }
                    });

                    const grandTotal = hargaKamar + totalService;
                    displayTotal.innerText = new Intl.NumberFormat('id-ID').format(grandTotal);
                    inputTotal.value = grandTotal;
                    inputCheckIn.value = tgl1;
                    inputCheckOut.value = tgl2;
                    displayDurasi.innerText = diffDays + ' Hari';
                    if (btn) btn.disabled = false;
                } else {
                    displayTotal.innerText = '0';
                    inputTotal.value = '0';
                    displayDurasi.innerText = '0 Hari';
                    if (btn) btn.disabled = true;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const config = {
                altInput: true,
                altFormat: 'd/m/Y',
                dateFormat: 'Y-m-d',
                minDate: 'today',
                onChange: hitungTotal,
            };
            flatpickr('#tglMulai', {
                ...config,
                defaultDate: 'today'
            });
            flatpickr('#tglSelesai', {
                ...config,
                defaultDate: new Date(Date.now() + 86400000)
            });
            setTimeout(hitungTotal, 300);
        });
    </script>

    <style>
        .flatpickr-calendar {
            width: 300px !important;
            border-radius: 16px !important;
            box-shadow: 0 20px 40px -8px rgba(0, 0, 0, 0.12) !important;
            border: 1px solid #e2e8f0 !important;
            padding: 8px !important;
            font-family: inherit !important;
        }

        .flatpickr-day {
            border-radius: 8px !important;
            font-weight: 600;
            height: 36px !important;
            line-height: 36px !important;
            font-size: 13px !important;
        }

        .flatpickr-day.selected,
        .flatpickr-day.selected:hover {
            background: #1E293B !important;
            border-color: #1E293B !important;
        }

        .flatpickr-day:hover {
            background: #f1f5f9 !important;
            border-color: transparent !important;
        }

        .flatpickr-current-month {
            font-size: 14px !important;
            font-weight: 700 !important;
        }

        .flatpickr-weekday {
            font-size: 11px !important;
            font-weight: 600 !important;
            color: #94a3b8 !important;
        }
    </style>
@endsection
