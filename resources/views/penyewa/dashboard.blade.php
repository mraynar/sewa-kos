@extends('penyewa.layouts.app')

@section('content')
    <section id="home" class="bg-white min-h-[calc(100vh-64px)] flex items-center">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-10 lg:py-16 w-full">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">

                <div>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 text-slate-500 text-xs font-semibold rounded-full tracking-wide mb-8">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        Hunian Mahasiswa Surabaya
                    </span>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 leading-[1.08] tracking-tight mb-6">
                        Kamar Nyaman,<br>
                        Prestasi <span class="text-primary">Dimulai</span><br>
                        Dari Sini.
                    </h1>

                    <p class="text-base lg:text-lg text-slate-500 leading-relaxed mb-8 max-w-md">
                        Fasilitas lengkap, 5 menit dari kampus UPN Veteran Jawa Timur. Dikelola secara digital, profesional.
                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="#daftar-kamar"
                            class="px-6 py-3 bg-primary text-white font-semibold text-sm rounded-xl hover:bg-primary/90 transition-all duration-200 shadow-lg shadow-primary/25">
                            Lihat Kamar
                        </a>
                        <a href="https://wa.me/6289502390206" target="_blank"
                            class="px-6 py-3 bg-slate-100 text-slate-700 font-semibold text-sm rounded-xl hover:bg-slate-200 transition-all duration-200 flex items-center gap-2">
                            <i class="fab fa-whatsapp text-emerald-500"></i>
                            Hubungi Kami
                        </a>
                    </div>

                    <div class="flex items-center gap-6 mt-10 pt-10 border-t border-slate-100">
                        <div>
                            <p class="text-2xl font-black text-slate-900">5 Mnt</p>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">Dari kampus UPN</p>
                        </div>
                        <div class="w-px h-8 bg-slate-200"></div>
                        <div>
                            <p class="text-2xl font-black text-slate-900">24 Jam</p>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">CCTV & keamanan</p>
                        </div>
                        <div class="w-px h-8 bg-slate-200"></div>
                        <div>
                            <p class="text-2xl font-black text-slate-900">100%</p>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">Digital & terverifikasi</p>
                        </div>
                    </div>
                </div>

                <div class="relative hidden lg:block">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-slate-200" style="height: 560px;">
                        <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&q=80&w=800"
                            alt="Griya Asri Kos" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent">
                        </div>
                        <div class="absolute bottom-6 left-6">
                            <p class="text-white font-bold text-sm">Griya Asri Kos</p>
                            <p class="text-white/60 text-xs mt-0.5">Gunung Anyar, Surabaya</p>
                        </div>

                        <div
                            class="absolute bottom-6 right-6 bg-white/15 backdrop-blur-md border border-white/20 rounded-xl px-3 py-2 flex items-center gap-2">
                            <div class="w-6 h-6 bg-emerald-500/20 rounded-md flex items-center justify-center">
                                <i class="fas fa-shield-alt text-emerald-400 text-[10px]"></i>
                            </div>
                            <div>
                                <p class="text-white text-[10px] font-bold leading-none">Terverifikasi</p>
                                <p class="text-white/60 text-[9px] mt-0.5">Security 2026</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @auth
        @php
            $activeBooking = \App\Models\Booking::with(['room.roomType'])
                ->where('user_id', auth()->id())
                ->where('status', 'paid')
                ->latest()
                ->first();
        @endphp

        @if ($activeBooking)
            @php
                $bookingServices = \App\Models\BookingService::with('additionalService')
                    ->where('booking_id', $activeBooking->id)
                    ->get();
            @endphp
            <section class="py-16 bg-slate-50 border-b border-slate-200">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <!-- Section Title -->
                    <div class="flex items-center gap-2 mb-8 text-left">
                        <div class="w-1.5 h-5 bg-primary rounded-full"></div>
                        <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Status Hunian Aktif</h3>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Card 1: Kamar Info -->
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 text-left space-y-4 lg:col-span-1">
                            <div class="flex items-center justify-between">
                                <span class="text-[9px] font-black bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full border border-emerald-100 uppercase">
                                    Aktif Menghuni
                                </span>
                            </div>
                            <div>
                                <h4 class="text-2xl font-black text-slate-800">Kamar {{ $activeBooking->room->room_number }}</h4>
                                <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ $activeBooking->room->roomType->name }}</p>
                            </div>
                            <div class="pt-4 border-t border-slate-100 space-y-2">
                                <div class="flex justify-between text-xs font-semibold">
                                    <span class="text-slate-400 uppercase">Check In</span>
                                    <span class="text-slate-700">{{ \Carbon\Carbon::parse($activeBooking->check_in)->translatedFormat('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between text-xs font-semibold">
                                    <span class="text-slate-400 uppercase">Check Out</span>
                                    <span class="text-slate-700">{{ \Carbon\Carbon::parse($activeBooking->check_out)->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Layanan Tambahan -->
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 text-left lg:col-span-2 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[9px] font-black bg-blue-50 text-blue-600 px-3 py-1 rounded-full border border-blue-100 uppercase">
                                    Layanan Tambahan Aktif
                                </span>
                            </div>
                            
                            @if ($bookingServices->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="border-b border-slate-100">
                                                <th class="text-[9px] font-black text-slate-400 uppercase tracking-widest pb-3">Layanan</th>
                                                <th class="text-[9px] font-black text-slate-400 uppercase tracking-widest pb-3 text-center">Jumlah</th>
                                                <th class="text-[9px] font-black text-slate-400 uppercase tracking-widest pb-3 text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach ($bookingServices as $service)
                                                <tr>
                                                    <td class="py-3 text-xs font-bold text-slate-800">
                                                        {{ $service->additionalService->service_name ?? 'Layanan' }}
                                                    </td>
                                                    <td class="py-3 text-xs font-bold text-slate-700 text-center">
                                                        {{ $service->quantity }}
                                                    </td>
                                                    <td class="py-3 text-center">
                                                        @php
                                                            $badge_class = 'bg-amber-100 text-amber-600 border border-amber-200';
                                                            $status_text = 'Belum Dikerjakan';
                                                            
                                                            if ($service->service_status === 'done') {
                                                                $badge_class = 'bg-emerald-100 text-emerald-600 border border-emerald-200';
                                                                $status_text = 'Selesai';
                                                            } elseif ($service->service_status === 'on_progress') {
                                                                $badge_class = 'bg-blue-100 text-blue-600 border border-blue-200';
                                                                $status_text = 'Sedang Dikerjakan';
                                                            }
                                                        @endphp
                                                        <span class="px-2.5 py-0.5 rounded-full text-[8px] font-black uppercase {{ $badge_class }}">
                                                            {{ $status_text }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center py-6">
                                    <i class="fa-solid fa-bell-slash text-2xl text-slate-200 mb-2"></i>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tidak ada layanan tambahan aktif</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endauth

    <section id="daftar-kamar" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="mb-10">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Pilihan Kamar</h2>
                <p class="text-slate-500 text-base">Temukan kamar yang sesuai kebutuhan dan anggaran Anda.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-4 mb-8">

                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <a href="{{ route('home', array_filter(['search' => request('search')])) }}#daftar-kamar"
                        class="whitespace-nowrap px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200
                        {{ !request('category') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-white text-slate-500 border border-slate-200 hover:border-slate-300' }}">
                        Semua
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('home', array_filter(['category' => $cat->id, 'search' => request('search')])) }}#daftar-kamar"
                            class="whitespace-nowrap px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200
                            {{ (request('category') == $cat->id || strtolower(request('category')) == strtolower($cat->name)) ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-white text-slate-500 border border-slate-200 hover:border-slate-300' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <div class="lg:ml-auto w-full lg:w-auto">
                    <form action="{{ route('home') }}#daftar-kamar" method="GET">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="relative flex">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-slate-400 text-xs"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nomor, tipe, atau fasilitas kamar..."
                                class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-l-lg text-sm font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all w-full sm:w-64">
                            <button type="submit"
                                class="px-5 bg-primary text-white text-sm font-semibold rounded-r-lg hover:bg-primary/90 transition-all">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div x-data="{ limit: 8, total: {{ $rooms->count() }} }">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($rooms as $index => $room)
                        <div x-show="{{ $index }} < limit" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            class="bg-white rounded-xl border border-slate-200 overflow-hidden flex flex-col group relative hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/60 transition-all duration-300">

                            @if ($room->status !== 'available')
                                <div
                                    class="absolute inset-0 bg-slate-900/30 backdrop-blur-[1px] z-20 flex items-center justify-center">
                                    <div class="bg-white px-3 py-1.5 rounded-lg shadow-lg">
                                        <p class="text-[10px] font-bold text-slate-700 uppercase tracking-wide">
                                            <i class="fas fa-ban mr-1 text-red-400"></i> Tidak Tersedia
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                                <img src="{{ asset('images/room_types/' . $room->roomType->image) }}"
                                    alt="Kamar {{ $room->roomType->name }}"
                                    class="w-full h-full object-cover {{ $room->status === 'available' ? 'group-hover:scale-105' : 'grayscale' }} transition-transform duration-500">
                                <div class="absolute top-2.5 left-2.5 right-2.5 flex justify-between">
                                    <span
                                        class="text-[10px] font-semibold px-2 py-1 bg-white/90 backdrop-blur text-slate-700 rounded-md shadow-sm">
                                        {{ $room->roomType->name }}
                                    </span>
                                    <span
                                        class="text-[10px] font-semibold px-2 py-1 rounded-md shadow-sm text-white
                                        {{ $room->gender_type == 'Putra' ? 'bg-primary' : 'bg-pink-500' }}">
                                        {{ $room->gender_type }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 flex flex-col flex-grow">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="text-sm font-bold text-slate-800">No. {{ $room->room_number }}</h3>
                                    <span class="flex items-center gap-1 text-xs font-semibold text-amber-500">
                                        <i class="fas fa-star text-[10px]"></i> {{ $room->rating }}
                                    </span>
                                </div>
                                <div class="mb-4">
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-0.5">
                                        Harga sewa</p>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-base font-black text-slate-900">Rp
                                            {{ number_format($room->price) }}</span>
                                        <span class="text-xs text-slate-400 font-medium">/bln</span>
                                    </div>
                                </div>
                                <div class="mt-auto">
                                    @if ($room->status === 'available')
                                        <a href="{{ route('kamar.show', $room->id) }}"
                                            class="block text-center bg-primary text-white py-2 rounded-lg font-semibold text-sm hover:bg-primary/90 transition-all duration-200">
                                            Lihat Detail
                                        </a>
                                    @else
                                        <button disabled
                                            class="w-full bg-slate-100 text-slate-400 py-2 rounded-lg font-semibold text-sm cursor-not-allowed">
                                            Tidak Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 text-center" x-show="total > 8">
                    <button x-show="limit < total" @click="limit = total"
                        class="inline-flex items-center gap-2 px-8 py-3 bg-white border border-slate-200 text-slate-700 font-semibold text-sm rounded-xl hover:border-slate-300 hover:bg-slate-50 transition-all duration-200 shadow-sm">
                        Tampilkan Semua Kamar
                        <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                    </button>
                    <button x-show="limit >= total"
                        @click="limit = 8; setTimeout(() => { document.getElementById('daftar-kamar').scrollIntoView({ behavior: 'smooth', block: 'start' }) }, 50)"
                        class="inline-flex items-center gap-2 px-8 py-3 bg-white border border-slate-200 text-slate-500 font-semibold text-sm rounded-xl hover:bg-slate-50 transition-all duration-200 shadow-sm">
                        Tampilkan Lebih Sedikit
                        <i class="fas fa-chevron-up text-xs text-slate-400"></i>
                    </button>
                </div>
            </div>

        </div>
    </section>

    <section id="about" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <div>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 text-slate-500 text-xs font-semibold rounded-full tracking-wide mb-8">
                        <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                        Tentang Kami
                    </span>

                    <h2 class="text-4xl font-black text-slate-900 tracking-tight leading-tight mb-6">
                        Hunian Strategis<br>untuk Mahasiswa UPN.
                    </h2>

                    <div class="space-y-4 text-slate-500 text-base leading-relaxed mb-10">
                        <p>Kami memahami bahwa lingkungan tenang adalah kunci sukses akademik. <strong
                                class="text-slate-700 font-semibold">Griya Asri Kos</strong> menyediakan lebih dari sekadar
                            kamar — kami menyediakan ekosistem belajar yang mendukung.</p>
                        <p>Berlokasi di Gunung Anyar, akses tercepat menuju kampus. Dengan manajemen digital profesional,
                            setiap kebutuhan penghuni ditangani secara instan.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="p-5 bg-slate-50 rounded-xl border border-slate-200 hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 group">
                            <p class="text-2xl font-black text-slate-900 group-hover:text-primary transition-colors">5
                                Menit</p>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mt-1">Jarak ke Kampus
                            </p>
                        </div>
                        <div
                            class="p-5 bg-slate-50 rounded-xl border border-slate-200 hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 group">
                            <p class="text-2xl font-black text-slate-900 group-hover:text-primary transition-colors">24 Jam
                            </p>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mt-1">CCTV & Security
                            </p>
                        </div>
                    </div>
                </div>

                <div class="relative hidden lg:block">
                    <div class="relative rounded-2xl overflow-hidden shadow-xl shadow-slate-200" style="height: 480px;">
                        <img src="/images/about/male-female-students-wear-face-chill-stand-front-university.jpg"
                            class="w-full h-full object-cover" alt="Suasana Griya Asri Kos">
                    </div>
                    <div
                        class="absolute -bottom-5 -left-5 bg-white border border-slate-100 rounded-2xl px-5 py-4 shadow-xl shadow-slate-200/60">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-emerald-500 text-base"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 leading-none">Terverifikasi</p>
                                <p class="text-[10px] text-slate-400 font-medium mt-0.5 uppercase tracking-widest">Security
                                    System 2026</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection
