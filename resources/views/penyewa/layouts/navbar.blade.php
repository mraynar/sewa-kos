<nav x-data="{ activeSection: 'beranda', scrolled: false }"
    @scroll.window="
        let y = window.pageYOffset;
        scrolled = y > 20;
        if (y < 600) activeSection = 'beranda';
        else if (y < 1400) activeSection = 'kamar';
        else activeSection = 'about';"
    :class="scrolled ? 'bg-white/95 shadow-sm shadow-slate-200/50' : 'bg-white/80'"
    class="backdrop-blur-xl sticky top-0 z-50 border-b border-slate-100 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <div class="flex-shrink-0">
                <a href="/" class="flex items-center gap-2.5">
                    <span
                        class="w-7 h-7 bg-primary rounded-lg flex items-center justify-center shadow-md shadow-primary/30">
                        <i class="fas fa-home text-white text-[11px]"></i>
                    </span>
                    <span class="text-base font-black text-slate-900 tracking-tight">Griya Asri Kos</span>
                </a>
            </div>

            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" @click="activeSection = 'beranda'"
                    :class="activeSection === 'beranda' && !{{ request()->is('profile') ? 'true' : 'false' }} ?
                        'text-slate-900 bg-slate-100' :
                        'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">
                    Beranda
                </a>
                <a href="/#daftar-kamar" @click="activeSection = 'kamar'"
                    :class="activeSection === 'kamar' && !{{ request()->is('profile') ? 'true' : 'false' }} ?
                        'text-slate-900 bg-slate-100' :
                        'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">
                    Kamar
                </a>
                <a href="/#about" @click="activeSection = 'about'"
                    :class="activeSection === 'about' && !{{ request()->is('profile') ? 'true' : 'false' }} ?
                        'text-slate-900 bg-slate-100' :
                        'text-slate-500 hover:text-slate-900 hover:bg-slate-50'"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">
                    Tentang
                </a>
            </div>

            <div class="flex items-center gap-3 flex-shrink-0">
                @auth
                    <div class="hidden md:flex items-center gap-1 text-right">
                        <div class="pr-3 border-r border-slate-100">
                            <p
                                class="text-[10px] font-semibold uppercase text-slate-400 tracking-widest leading-none mb-0.5">
                                Mahasiswa</p>
                            <p class="text-sm font-bold text-slate-800 truncate max-w-[120px]">{{ Auth::user()->nickname }}
                            </p>
                        </div>
                    </div>

                    @if (Auth::user()->role === 'penyewa')
                        <a href="{{ route('profile') }}"
                            class="flex items-center justify-center w-9 h-9 rounded-xl transition-all duration-200
                            {{ request()->is('profile')
                                ? 'bg-primary text-white shadow-md shadow-primary/30'
                                : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <i class="fas fa-user-graduate text-sm"></i>
                        </a>
                    @else
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center justify-center w-9 h-9 rounded-xl bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-red-500 transition-all duration-200">
                                <i class="fas fa-sign-out-alt text-sm"></i>
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors px-3 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-primary text-white px-5 py-2 rounded-lg font-semibold text-sm hover:bg-primary/90 transition-all duration-200 shadow-md shadow-primary/20">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
