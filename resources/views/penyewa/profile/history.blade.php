<div class="mb-8">
    <h3 class="text-lg font-bold text-slate-900 mb-1">Riwayat Penyewaan</h3>
    <p class="text-sm text-slate-400">Semua riwayat booking kamar Anda</p>
</div>

{{-- ─── Cancel-booking side effect (preserved exactly as-is) ────────────── --}}
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

{{-- ─── Search & Filter Controls ────────────────────────────────────────── --}}
<div class="flex flex-col md:flex-row gap-3 mb-6">

    {{-- Search input --}}
    <div class="relative flex-1">
        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-xs pointer-events-none"></i>
        <input
            id="history-search"
            type="text"
            placeholder="Cari nomor kamar, tipe, harga, atau ID booking..."
            class="w-full pl-9 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder:text-slate-300 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all">
    </div>

    {{-- Status filter --}}
    <div class="relative">
        <select
            id="history-status"
            class="w-full md:w-48 px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all appearance-none cursor-pointer pr-9">
            <option value="">Semua Status</option>
            <option value="Lunas">Lunas</option>
            <option value="Ditempati">Ditempati</option>
            <option value="Selesai">Selesai</option>
            <option value="pending">Pending</option>
            <option value="expired">Kedaluwarsa</option>
            <option value="canceled">Dibatalkan</option>
        </select>
        <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
            <i class="fas fa-chevron-down text-[10px]"></i>
        </div>
    </div>

    {{-- Bulan (month) filter --}}
    <div class="relative">
        <select
            id="history-bulan"
            class="w-full md:w-40 px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all appearance-none cursor-pointer pr-9">
            <option value="">Semua Bulan</option>
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>
        <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
            <i class="fas fa-chevron-down text-[10px]"></i>
        </div>
    </div>

    {{-- Tahun (year) filter — options derived from user's actual booking years --}}
    <div class="relative">
        <select
            id="history-tahun"
            class="w-full md:w-32 px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all appearance-none cursor-pointer pr-9">
            <option value="">Semua Tahun</option>
            @foreach ($availableYears->sortDesc() as $yr)
                <option value="{{ $yr }}">{{ $yr }}</option>
            @endforeach
        </select>
        <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
            <i class="fas fa-chevron-down text-[10px]"></i>
        </div>
    </div>

</div>

{{-- ─── Booking list — initial render via @include, swapped by JS on filter ── --}}
@php
    $bookings = \App\Models\Booking::with(['room.roomType'])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
    $filtered = false;
@endphp

<div id="history-list-container">
    @include('penyewa.profile.partials.history-list', ['bookings' => $bookings, 'filtered' => false])
</div>

<script>
(function () {
    const searchInput  = document.getElementById('history-search');
    const statusSelect = document.getElementById('history-status');
    const bulanSelect  = document.getElementById('history-bulan');
    const tahunSelect  = document.getElementById('history-tahun');
    const container    = document.getElementById('history-list-container');
    const endpoint     = '{{ route('profile.history.search') }}';

    let debounceTimer = null;

    function fetchResults() {
        const params = new URLSearchParams();

        const search = searchInput.value.trim();
        const status = statusSelect.value;
        const bulan  = bulanSelect.value;  // "1"–"12" or ""
        const tahun  = tahunSelect.value;  // e.g. "2026" or ""

        if (search) params.set('search', search);
        if (status) params.set('status', status);

        // Period filter only applies when BOTH month and year are selected.
        // Sending one without the other intentionally does nothing on the backend.
        if (bulan && tahun) {
            params.set('month', bulan);
            params.set('year', tahun);
        }

        // Show a subtle loading state without removing content
        container.style.opacity = '0.5';
        container.style.pointerEvents = 'none';

        fetch(endpoint + (params.toString() ? '?' + params.toString() : ''), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (response) {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(function (html) {
            container.innerHTML = html;
        })
        .catch(function () {
            // On network failure restore the old content silently
        })
        .finally(function () {
            container.style.opacity = '1';
            container.style.pointerEvents = '';
        });
    }

    // Debounced search (350ms)
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchResults, 350);
    });

    // Instant response on any dropdown change
    statusSelect.addEventListener('change', function () {
        clearTimeout(debounceTimer);
        fetchResults();
    });

    bulanSelect.addEventListener('change', function () {
        clearTimeout(debounceTimer);
        fetchResults();
    });

    tahunSelect.addEventListener('change', function () {
        clearTimeout(debounceTimer);
        fetchResults();
    });
}());
</script>
