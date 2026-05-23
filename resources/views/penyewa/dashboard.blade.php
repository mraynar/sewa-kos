@extends('penyewa.layouts.app')

@section('content')
    <section id="home" class="bg-white min-h-[calc(100vh-64px)] flex items-center">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <div>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 text-slate-500 text-xs font-semibold rounded-full tracking-wide mb-8">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        Hunian Mahasiswa Surabaya
                    </span>

                    <h1 class="text-5xl lg:text-6xl font-black text-slate-900 leading-[1.08] tracking-tight mb-6">
                        Kamar Nyaman,<br>
                        Prestasi <span class="text-primary">Dimulai</span><br>
                        Dari Sini.
                    </h1>

                    <p class="text-lg text-slate-500 leading-relaxed mb-10 max-w-md">
                        Fasilitas lengkap, 5 menit dari kampus UPN Veteran Jawa Timur. Dikelola secara digital, profesional.
                    </p>

                    <div class="flex items-center gap-4">
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

    <section id="daftar-kamar" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="mb-10">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Pilihan Kamar</h2>
                <p class="text-slate-500 text-base">Temukan kamar yang sesuai kebutuhan dan anggaran Anda.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-4 mb-8">

                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <a href="{{ route('home') }}#daftar-kamar"
                        class="whitespace-nowrap px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200
                        {{ !request('category') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-white text-slate-500 border border-slate-200 hover:border-slate-300' }}">
                        Semua
                    </a>
                    @foreach ($categories as $cat)
                        <a href="?category={{ $cat->id }}#daftar-kamar"
                            class="whitespace-nowrap px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200
                            {{ request('category') == $cat->id ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-white text-slate-500 border border-slate-200 hover:border-slate-300' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <div class="lg:ml-auto">
                    <form action="{{ route('home') }}#daftar-kamar" method="GET">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="relative flex">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-slate-400 text-xs"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari fasilitas..."
                                class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-l-lg text-sm font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all w-64">
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
