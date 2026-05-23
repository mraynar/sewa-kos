@extends('penyewa.layouts.app')

@section('content')
    <div class="pt-6 pb-20 px-4 bg-[#f8fafc] min-h-screen font-sans">
        <div class="max-w-4xl mx-auto">

            <div class="flex items-center justify-center mb-8 gap-3">
                <div class="flex items-center gap-2 opacity-40">
                    <span
                        class="w-7 h-7 rounded-full bg-slate-500 text-white flex items-center justify-center text-[10px] font-black">1</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase italic">Pilih</span>
                </div>
                <div class="w-8 h-[1px] bg-slate-300"></div>

                <div class="flex items-center gap-2 opacity-40">
                    <span
                        class="w-7 h-7 rounded-full bg-slate-500 text-white flex items-center justify-center text-[10px] font-black">2</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase italic">Konfirmasi</span>
                </div>
                <div class="w-8 h-[1px] bg-slate-300"></div>

                <div class="flex items-center gap-2">
                    <span
                        class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center text-xs font-black shadow-lg shadow-primary/20 scale-110 ring-4 ring-primary/10">3</span>
                    <span
                        class="text-xs font-black text-primary uppercase italic underline underline-offset-4 decoration-2">Pembayaran</span>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white text-xs shadow-md shadow-primary/20">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h1 class="text-sm font-black text-slate-800 uppercase tracking-tighter">Secure Checkout</h1>
                </div>
                <div class="flex items-center gap-3 bg-amber-50 px-4 py-1.5 rounded-xl border border-amber-100">
                    <p class="text-[8px] font-black text-amber-600 uppercase">Sisa Waktu</p>
                    <p class="text-[10px] font-black text-slate-700" id="timer">23 : 59 : 59</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

                <div class="lg:col-span-7 flex">
                    <div
                        class="bg-white rounded-[35px] border border-slate-100 shadow-sm overflow-hidden w-full flex flex-col">
                        <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                            <div>
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest text-left">Batas
                                    Bayar</p>
                                <p class="text-[11px] font-black text-slate-700">{{ $deadline }}</p>
                            </div>
                            <span
                                class="text-[9px] font-black text-emerald-600 uppercase bg-emerald-50 px-3 py-1 rounded-lg">
                                <i class="fas fa-lock mr-1"></i> Secured
                            </span>
                        </div>

                        <div id="snap-container" class="w-full flex-grow bg-white relative overflow-hidden min-h-[400px]">
                            <div id="loading-payment"
                                class="absolute inset-0 flex flex-col items-center justify-center bg-white z-50 text-center px-6">
                                <div
                                    class="w-8 h-8 border-[3px] border-primary border-t-transparent rounded-full animate-spin mb-3">
                                </div>
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">
                                    Menyiapkan<br>Metode Pembayaran</p>
                            </div>
                        </div>

                        <div class="px-6 py-3 border-t border-slate-50 bg-slate-50/30 flex justify-between items-center">
                            <p class="text-[8px] text-slate-500 font-black uppercase tracking-widest">Griya Asri Kos &copy;
                                {{ date('Y') }}</p>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_Midtrans.png"
                                class="h-2 opacity-20 grayscale" alt="Midtrans">
                        </div>

                        <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/20">
                            <div class="flex items-center justify-center gap-8 opacity-40 grayscale text-slate-500">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-shield-check text-xs"></i>
                                    <span class="text-[8px] font-black uppercase tracking-widest">Verified System</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-lock text-[9px]"></i>
                                    <span class="text-[8px] font-black uppercase tracking-widest">SSL Encrypted</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user-shield text-[10px]"></i>
                                    <span class="text-[8px] font-black uppercase tracking-widest">Privacy Protected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 flex">
                    <div
                        class="bg-white rounded-[40px] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden w-full flex flex-col justify-between">

                        <div>
                            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                                <h3
                                    class="text-[10px] font-black text-slate-800 uppercase tracking-[0.2em] flex items-center gap-2 text-left">
                                    <i class="fas fa-receipt text-primary text-xs"></i> Ringkasan Pesanan
                                </h3>
                            </div>

                            <div class="p-7 space-y-6">
                                <div
                                    class="relative w-full h-36 rounded-[32px] overflow-hidden border-4 border-slate-100 shadow-sm bg-slate-100">
                                    <img src="{{ asset('images/room_types/' . $room->roomType->image) }}"
                                        class="w-full h-full object-cover" alt="Kamar {{ $room->room_number }}">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                    <div class="absolute bottom-4 left-5 text-white text-left">
                                        <p class="text-[14px] font-black tracking-tighter leading-none">Kamar
                                            {{ $room->room_number }}</p>
                                        <p class="text-[9px] font-bold uppercase tracking-widest opacity-80">
                                            {{ $room->roomType->name }}</p>
                                    </div>
                                </div>

                                <div class="space-y-4 pt-2 text-left">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Detail Hunian
                                    </p>

                                    <div
                                        class="flex justify-between items-center border-b border-dashed border-slate-100 pb-3">
                                        <span class="text-[10px] font-bold text-slate-500">Periode Sewa</span>
                                        <span class="text-[10px] font-black text-slate-800">
                                            {{ $checkIn->translatedFormat('d M Y') }} –
                                            {{ $checkOut->translatedFormat('d M Y') }}
                                        </span>
                                    </div>

                                    <div
                                        class="flex justify-between items-center border-b border-dashed border-slate-100 pb-3">
                                        <span class="text-[10px] font-bold text-slate-500">Durasi Total</span>
                                        <span class="text-[10px] font-black text-slate-800">{{ $days }} Hari</span>
                                    </div>

                                    <div
                                        class="flex justify-between items-center border-b border-dashed border-slate-100 pb-3">
                                        <span class="text-[10px] font-bold text-slate-500">Tipe Kamar</span>
                                        <span
                                            class="text-[10px] font-black text-slate-800 uppercase tracking-tighter">{{ $room->roomType->name }}</span>
                                    </div>

                                    @if (!empty($serviceDetails))
                                        <div class="space-y-2">
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                                Layanan Tambahan</p>
                                            @foreach ($serviceDetails as $s)
                                                <div class="flex justify-between items-center">
                                                    <span
                                                        class="text-[10px] font-bold text-slate-500">{{ $s['name'] }}</span>
                                                    <span class="text-[10px] font-black text-primary">Rp
                                                        {{ number_format($s['cost'], 0, ',', '.') }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="py-2 space-y-3">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-map-marker-alt text-[10px] text-primary"></i>
                                            <span class="text-[10px] font-bold text-slate-500">Surabaya, Jawa Timur</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-shield-check text-[10px] text-emerald-500"></i>
                                            <span class="text-[10px] font-bold text-emerald-600">Terverifikasi Griya
                                                Asri</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-7 pb-8 space-y-4">
                            <div class="pt-6 border-t-4 border-double border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-3 text-left">
                                    Tagihan Akhir</p>

                                <div
                                    class="flex items-center justify-between bg-slate-900 p-5 rounded-2xl shadow-lg shadow-primary/20 mb-3">
                                    <div>
                                        <p class="text-[10px] text-white font-black uppercase mb-2 tracking-widest">Total
                                            Bayar</p>
                                        <p class="text-xl font-black text-white tracking-tighter leading-none">
                                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <button onclick="copyPrice({{ $grandTotal }})"
                                        class="w-10 h-10 bg-white/10 rounded-xl text-white hover:bg-white hover:text-primary transition-all flex items-center justify-center border border-white/5">
                                        <i class="far fa-copy"></i>
                                    </button>
                                </div>

                                <a href="{{ route('profile', ['tab' => 'history']) }}"
                                    class="flex items-center justify-center gap-3 w-full p-5 bg-slate-100 border border-slate-200 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-red-50 hover:text-red-600 transition-all shadow-sm">
                                    <i class="fas fa-times-circle text-xs"></i>
                                    Batalkan & Lihat Pesanan
                                </a>
                            </div>

                            <p class="text-[8px] text-slate-300 font-black uppercase tracking-[0.4em] text-center pt-2">
                                Griya Asri Kos &copy; {{ date('Y') }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        (function() {
            let timer = 86400;
            const display = document.getElementById('timer');
            setInterval(() => {
                const h = String(Math.floor(timer / 3600)).padStart(2, '0');
                const m = String(Math.floor((timer % 3600) / 60)).padStart(2, '0');
                const s = String(timer % 60).padStart(2, '0');
                display.textContent = `${h} : ${m} : ${s}`;
                if (timer > 0) timer--;
            }, 1000);
        })();

        function copyPrice(price) {
            navigator.clipboard.writeText(price);
            alert('Nominal berhasil disalin!');
        }

        window.addEventListener('load', function() {
            fetch('{{ route('transactions.checkout') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        room_id: '{{ $room->id }}',
                        check_in: '{{ $checkIn->toDateString() }}',
                        check_out: '{{ $checkOut->toDateString() }}',
                        total_price: {{ $grandTotal }},
                        service_details: {!! json_encode($serviceDetails) !!}
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.token) {
                        document.getElementById('loading-payment').style.display = 'none';
                        window.snap.embed(data.token, {
                            embedId: 'snap-container',
                            onSuccess: () => window.location.href =
                                '{{ route('profile', ['tab' => 'history']) }}',
                            onPending: () => window.location.href =
                                '{{ route('profile', ['tab' => 'history']) }}',
                            onError: (result) => console.error('Snap error', result),
                        });
                    } else {
                        document.getElementById('loading-payment').innerHTML = `
                    <i class="fas fa-exclamation-triangle text-red-500 mb-2 text-2xl"></i>
                    <p class="text-[10px] font-black text-red-500 uppercase mt-2">Gagal memuat pembayaran<br><span class="text-slate-400 normal-case font-bold">Coba refresh halaman</span></p>
                `;
                    }
                })
                .catch(() => {
                    document.getElementById('loading-payment').innerHTML =
                        '<p class="text-red-500 text-[10px] font-black uppercase">Koneksi Bermasalah</p>';
                });
        });
    </script>
@endsection
