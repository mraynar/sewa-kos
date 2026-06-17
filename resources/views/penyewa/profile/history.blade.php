<div class="mb-8">
    <h3 class="text-lg font-bold text-slate-900 mb-1">Riwayat Penyewaan</h3>
    <p class="text-sm text-slate-400">Semua riwayat booking kamar Anda</p>
</div>

@php
    $bookings = \App\Models\Booking::with(['room.roomType'])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

@if (request('cancel_id'))
    @php
        \App\Models\Booking::where('id', request('cancel_id'))
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->delete();
    @endphp
    <script>
        window.location.href = '{{ route('profile', ['tab' => 'history']) }}';
    </script>
@endif

@if ($bookings->count() > 0)
    <div class="space-y-4">
        @foreach ($bookings as $booking)
            <div
                class="bg-white border border-slate-200 rounded-xl p-5 flex flex-col md:flex-row items-center gap-5 hover:border-slate-300 hover:shadow-sm transition-all duration-200">

                <div
                    class="w-full md:w-28 h-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0">
                    <img src="{{ asset('images/room_types/' . $booking->room->roomType->image) }}"
                        class="w-full h-full object-cover" alt="Kamar {{ $booking->room->room_number }}">
                </div>

                <div class="flex-grow text-left min-w-0">
                    <p class="text-sm font-bold text-slate-900">Kamar No. {{ $booking->room->room_number }}</p>
                    <p class="text-xs text-slate-400 mt-1">
                        {{ \Carbon\Carbon::parse($booking->check_in)->translatedFormat('d M Y') }}
                        –
                        {{ \Carbon\Carbon::parse($booking->check_out)->translatedFormat('d M Y') }}
                    </p>
                    <div class="flex items-center gap-3 mt-2">
                        <span
                            class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d M Y') }}</span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span class="text-sm font-bold text-primary">Rp
                            {{ number_format($booking->total_price) }}</span>
                    </div>
                </div>

                <div class="flex flex-col gap-2 w-full md:w-auto md:min-w-[150px]">
                    @if ($booking->display_status === 'Ditempati')
                        <span
                            class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold text-center border border-blue-100">
                            <i class="fas fa-home mr-1"></i> Ditempati
                        </span>
                        <a href="{{ route('transactions.receipt', $booking->id) }}"
                            target="_blank"
                            class="px-4 py-2 bg-slate-900 text-white rounded-lg text-xs font-semibold text-center hover:bg-black transition-all">
                            <i class="fas fa-print mr-1"></i> Unduh Nota
                        </a>
                    @elseif ($booking->display_status === 'Selesai')
                        <span
                            class="px-4 py-1.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-semibold text-center border border-slate-200">
                            <i class="fas fa-check-double mr-1"></i> Selesai
                        </span>
                        <a href="{{ route('transactions.receipt', $booking->id) }}"
                            target="_blank"
                            class="px-4 py-2 bg-slate-900 text-white rounded-lg text-xs font-semibold text-center hover:bg-black transition-all">
                            <i class="fas fa-print mr-1"></i> Unduh Nota
                        </a>
                    @elseif ($booking->display_status === 'Lunas')
                        <span
                            class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-semibold text-center border border-emerald-100">
                            <i class="fas fa-check-circle mr-1"></i> Lunas
                        </span>
                        <a href="{{ route('transactions.receipt', $booking->id) }}"
                            target="_blank"
                            class="px-4 py-2 bg-slate-900 text-white rounded-lg text-xs font-semibold text-center hover:bg-black transition-all">
                            <i class="fas fa-print mr-1"></i> Unduh Nota
                        </a>
                    @elseif($booking->status === 'pending')
                        <span
                            class="px-4 py-1.5 bg-amber-50 text-amber-600 rounded-lg text-xs font-semibold text-center border border-amber-100">
                            <i class="fas fa-clock mr-1"></i> Pending
                        </span>
                        <a href="{{ route('profile', ['tab' => 'history', 'cancel_id' => $booking->id]) }}"
                            onclick="return confirm('Batalkan pesanan ini?')"
                            class="px-4 py-2 bg-red-50 text-red-500 rounded-lg text-xs font-semibold text-center hover:bg-red-100 transition-all border border-red-100">
                            <i class="fas fa-times mr-1"></i> Batalkan
                        </a>
                    @elseif($booking->status === 'expired')
                        <span
                            class="px-4 py-1.5 bg-slate-100 text-slate-400 rounded-lg text-xs font-semibold text-center border border-slate-200">
                            <i class="fas fa-ban mr-1"></i> Kedaluwarsa
                        </span>
                    @elseif($booking->status === 'canceled')
                        <span
                            class="px-4 py-1.5 bg-red-50 text-red-400 rounded-lg text-xs font-semibold text-center border border-red-100">
                            <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                        </span>
                    @else
                        <span
                            class="px-4 py-1.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-semibold text-center">
                            {{ ucfirst($booking->status) }}
                        </span>
                    @endif
                </div>

            </div>
        @endforeach
    </div>
@else
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300 mb-4">
            <i class="fas fa-clock-rotate-left text-xl"></i>
        </div>
        <p class="text-sm font-semibold text-slate-400">Belum ada riwayat penyewaan</p>
        <p class="text-xs text-slate-300 mt-1">Booking kamar pertama Anda akan muncul di sini</p>
        <a href="{{ route('home') }}"
            class="mt-5 px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all shadow-md shadow-primary/20">
            Lihat Kamar
        </a>
    </div>
@endif
