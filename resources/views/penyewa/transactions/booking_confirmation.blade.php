@extends('penyewa.layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen">

        <div class="max-w-3xl mx-auto px-6 lg:px-8 pt-8 pb-4">
            <a href="javascript:history.back()"
                class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="max-w-3xl mx-auto px-6 lg:px-8 pb-20">

            <div class="flex items-center justify-center mb-8 gap-2">
                <div class="flex items-center gap-2 opacity-40">
                    <span
                        class="w-6 h-6 rounded-full bg-slate-400 text-white flex items-center justify-center text-[10px] font-bold">1</span>
                    <span class="text-xs font-semibold text-slate-400">Pilih</span>
                </div>
                <div class="w-10 h-px bg-slate-300"></div>
                <div class="flex items-center gap-2">
                    <span
                        class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold shadow-md shadow-primary/20 ring-4 ring-primary/10">2</span>
                    <span class="text-xs font-bold text-primary">Konfirmasi</span>
                </div>
                <div class="w-10 h-px bg-slate-300"></div>
                <div class="flex items-center gap-2 opacity-40">
                    <span
                        class="w-6 h-6 rounded-full bg-slate-400 text-white flex items-center justify-center text-[10px] font-bold">3</span>
                    <span class="text-xs font-semibold text-slate-400">Pembayaran</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="relative h-52 overflow-hidden">
                    <img src="{{ asset('images/room_types/' . $room->roomType->image) }}" class="w-full h-full object-cover"
                        alt="Kamar {{ $room->room_number }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-6 flex items-center gap-2">
                        <span class="bg-primary text-white px-3 py-1 rounded-lg text-xs font-semibold">
                            {{ $room->roomType->name }}
                        </span>
                        <span class="bg-white/20 backdrop-blur text-white px-3 py-1 rounded-lg text-xs font-semibold">
                            Kamar {{ $room->room_number }}
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-6">

                    <div class="grid grid-cols-3 bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                        <div class="p-4 text-center border-r border-slate-200">
                            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1">Mulai</p>
                            <p class="text-sm font-bold text-slate-800">{{ $checkIn->translatedFormat('d M Y') }}</p>
                        </div>
                        <div class="p-4 text-center bg-slate-900">
                            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1">Durasi</p>
                            <p class="text-sm font-bold text-white">{{ $days }} Hari</p>
                        </div>
                        <div class="p-4 text-center border-l border-slate-200">
                            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
                            <p class="text-sm font-bold text-slate-800">{{ $checkOut->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-3">Rincian Pesanan</p>
                        <div class="space-y-2">
                            <div
                                class="flex justify-between items-center p-4 bg-slate-50 rounded-xl border border-slate-200">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Kamar No. {{ $room->room_number }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $days }} hari</p>
                                </div>
                                <span class="text-sm font-bold text-slate-900">Rp
                                    {{ number_format($roomPrice, 0, ',', '.') }}</span>
                            </div>

                            @foreach ($detailServices as $s)
                                <div
                                    class="flex justify-between items-center p-4 bg-white rounded-xl border border-slate-200 border-l-4 border-l-primary">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">{{ $s['name'] }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $s['qty'] }} {{ $s['unit'] }} ×
                                            Rp {{ number_format($s['price_unit'], 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-sm font-bold text-slate-700">Rp
                                        {{ number_format($s['cost'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            <div class="flex justify-between items-center pt-4 border-t border-dashed border-slate-200">
                                <div>
                                    <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold mb-1">Total
                                        Tagihan</p>
                                    <p class="text-2xl font-black text-primary">Rp
                                        {{ number_format($grandTotal, 0, ',', '.') }}</p>
                                </div>
                                <span
                                    class="flex items-center gap-1.5 text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg">
                                    <i class="fas fa-shield-halved"></i> Secure
                                </span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('transactions.payment') }}" method="POST"
                        class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <input type="hidden" name="check_in" value="{{ $checkIn->toDateString() }}">
                        <input type="hidden" name="check_out" value="{{ $checkOut->toDateString() }}">
                        <input type="hidden" name="grand_total" value="{{ $grandTotal }}">
                        <input type="hidden" name="service_details" value="{{ json_encode($detailServices) }}">

                        <a href="javascript:history.back()"
                            class="flex items-center justify-center gap-2 py-3 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition-all text-center">
                            <i class="fas fa-arrow-left text-xs"></i> Kembali
                        </a>
                        <button type="submit"
                            class="py-3 bg-primary text-white text-sm font-semibold rounded-xl shadow-md shadow-primary/20 hover:bg-primary/90 transition-all active:scale-95">
                            Lanjut Pembayaran <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
