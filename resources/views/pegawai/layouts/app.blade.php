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
  <div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white p-6 flex flex-col justify-between">
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
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Topbar -->
      <div class="bg-white shadow-sm border-b border-gray-100 p-6 flex justify-between items-center">
        <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">@yield('page_title', 'Dashboard')</h2>
        <div class="flex items-center space-x-4">
          <span class="text-sm font-bold text-gray-500">Halo, {{ Auth::user()->nickname ?? Auth::user()->name }}</span>
          <div class="text-lg font-black text-slate-800 border-l border-gray-200 pl-4" id="jam"></div>
        </div>
      </div>

      <!-- Page Content -->
      <div class="flex-1 overflow-auto p-8">
        @yield('content')
      </div>
    </div>
  </div>

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
