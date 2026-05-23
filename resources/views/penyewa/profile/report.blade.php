<div class="mb-8">
    <h3 class="text-lg font-bold text-slate-900 mb-1">Lapor Permasalahan Kamar</h3>
    <p class="text-sm text-slate-400">Sampaikan kendala kamar Anda agar segera kami tindaklanjuti</p>
</div>

@if ($activeBookings->isNotEmpty())
    <form action="{{ route('profile.report') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
        x-data="{
            bookings: {{ $activeBookings->map(
                    fn($b) => [
                        'id' => $b->id,
                        'room' => $b->room->room_number,
                        'range' =>
                            \Carbon\Carbon::parse($b->check_in)->translatedFormat('d M Y') .
                            ' – ' .
                            \Carbon\Carbon::parse($b->check_out)->translatedFormat('d M Y'),
                    ],
                )->toJson() }},
            selectedRange: ''
        }" x-init="selectedRange = bookings[0]?.range ?? ''">
        @csrf

        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">Informasi Kamar Aktif</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5 bg-slate-50 rounded-xl border border-slate-200">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nomor Kamar</label>
                    <div class="relative">
                        <select name="booking_id" required
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all appearance-none cursor-pointer"
                            x-on:change="selectedRange = bookings.find(b => b.id == $event.target.value)?.range ?? ''">
                            @foreach ($activeBookings as $booking)
                                <option value="{{ $booking->id }}">Kamar {{ $booking->room->room_number }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <i class="fas fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Masa Aktif Sewa</label>
                    <input type="text" :value="selectedRange" disabled
                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-400 cursor-not-allowed">
                </div>
            </div>
        </div>

        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-4">Detail Permasalahan</p>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Subjek Permasalahan</label>
                    <input type="text" name="issue_name" value="{{ old('issue_name') }}" required
                        placeholder="Contoh: AC tidak dingin, Lampu kamar mandi mati"
                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Deskripsi Kerusakan</label>
                    <textarea name="description" required rows="4"
                        placeholder="Mohon jelaskan kendala Anda agar teknisi kami dapat menyiapkan peralatan yang tepat..."
                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all resize-none">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Foto Bukti <span
                            class="text-slate-300 font-normal">(opsional)</span></label>
                    <input type="file" name="issue_photo" accept="image/*" capture="camera"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-500 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all
                        file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90 cursor-pointer">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100">
            <button type="submit"
                class="inline-flex items-center gap-2 px-8 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary/90 transition-all duration-200 shadow-md shadow-primary/20 active:scale-95">
                <i class="fas fa-paper-plane text-xs"></i>
                Kirim Laporan
            </button>
        </div>
    </form>
@else
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="w-14 h-14 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center text-xl mb-4">
            <i class="fas fa-lock"></i>
        </div>
        <h4 class="text-base font-bold text-slate-800 mb-1">Layanan Terkunci</h4>
        <p class="text-sm text-slate-400 max-w-xs">
            Fitur ini hanya tersedia bagi penghuni yang sedang memiliki masa sewa aktif di Griya Asri Kos.
        </p>
    </div>
@endif
