<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Pegawai - @yield('title', 'Sewa Kos')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .active {
      background-color: #2563eb;
      border-radius: 0.5rem;
    }
  </style>
</head>

<body class="bg-slate-100" onload="startTime()">
  <div class="flex h-screen" x-data="{ sidebarOpen: false }">

    {{-- Mobile overlay --}}
    <div class="fixed inset-0 bg-black/50 z-20 lg:hidden"
         x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- Sidebar -->
    <div class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-gray-900 text-white p-6 flex flex-col justify-between flex-shrink-0 transform transition-transform duration-300 lg:translate-x-0"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
      <div>
        <a href="{{ route('pegawai.dashboard') }}" class="flex gap-2 mb-8 items-center mx-2">
          <i class="fas fa-solid fa-user-tie text-blue-500 text-xl"></i>
          <h1 class="text-lg font-black text-white tracking-widest uppercase">
            Portal Pegawai
          </h1>
        </a>
        <nav class="space-y-3">
          <a href="{{ route('pegawai.dashboard') }}"
            class="@yield('dashboard_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition duration-200 text-sm font-semibold">
            <i class="fas fa-chart-line text-xs w-4"></i>
            <span>Dashboard</span>
          </a>
          <a href="{{ route('pegawai.tasks.index') }}"
            class="@yield('tasks_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition duration-200 text-sm font-semibold">
            <i class="fa-solid fa-list-check text-xs w-4"></i>
            <span>Tugas Layanan</span>
          </a>
          <a href="{{ route('pegawai.maintenance.index') }}"
            class="@yield('maintenance_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition duration-200 text-sm font-semibold">
            <i class="fa-solid fa-screwdriver-wrench text-xs w-4"></i>
            <span>Laporan Kerusakan</span>
          </a>
          <a href="{{ route('pegawai.profile.index') }}"
            class="@yield('profile_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition duration-200 text-sm font-semibold">
            <i class="fas fa-user text-xs w-4"></i>
            <span>Profil Saya</span>
          </a>
        </nav>
      </div>

      <!-- Logout Form at bottom -->
      <div class="pt-4 border-t border-gray-800">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full flex items-center space-x-3 p-3 text-red-400 hover:bg-red-950/30 hover:text-red-300 rounded-lg transition duration-200 text-sm font-semibold text-left">
            <i class="fas fa-sign-out-alt text-xs w-4"></i>
            <span>Keluar</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
      <!-- Topbar -->
      <div class="bg-white shadow-sm border-b border-gray-100 px-4 md:px-6 py-4 flex justify-between items-center">
        {{-- Hamburger (mobile only) --}}
        <button @click="sidebarOpen = !sidebarOpen"
          class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition flex-shrink-0 mr-3">
          <i class="fas fa-bars text-base"></i>
        </button>
        <h2 class="text-base md:text-xl font-black text-slate-800 uppercase tracking-tight truncate flex-1">@yield('page_title', 'Dashboard')</h2>
        <div class="flex items-center space-x-2 md:space-x-4 flex-shrink-0">
          <span class="hidden sm:block text-sm font-bold text-gray-500">Halo, {{ Auth::user()->nickname ?? Auth::user()->name }}</span>
          <div class="text-sm md:text-lg font-black text-slate-800 md:border-l md:border-gray-200 md:pl-4" id="jam"></div>
        </div>
      </div>

      <!-- Page Content -->
      <div class="flex-1 overflow-auto p-4 md:p-8">
        @yield('content')
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script>
    function startTime() {
      const today = new Date();
      let h = today.getHours();
      let m = today.getMinutes();
      let s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('jam').innerHTML = h + ":" + m + ":" + s;
      setTimeout(startTime, 1000);
    }

    function checkTime(i) {
      if (i < 10) {
        i = "0" + i;
      }
      return i;
    }
  </script>
</body>

</html>
