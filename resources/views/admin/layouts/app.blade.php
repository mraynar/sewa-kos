<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100" onload="startTime()">
  <style>
    .active {
      background-color: #2563eb;
      border-radius: 0.5rem;
    }
  </style>
  <div class="flex h-screen">
    <div class="w-64 bg-gray-900 text-white p-6">
      <a href="{{ route('admin.dashboard') }}" class="flex gap-2 mb-8 items-center mx-2">
        <i class="fas fa-home text-white text-xl"></i>
        <h1 class="text-2xl font-black text-primary tracking-tighter flex items-center gap-2">
          {{ \App\Models\Setting::where('key', 'site_title')->value('value') ?? 'Griya Asri Kos' }}
        </h1>
      </a>
      <nav class="space-y-4">
        <a href="{{ route('admin.dashboard') }}"
          class="@yield('dashboard_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition">
          <i class="fas fa-chart-line"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.properti.index') }}"
          class="@yield('properti_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition">
          <i class="fas fa-home"></i>
          <span>Properti</span>
        </a>
        <a href="{{ route('admin.additional_services.index') }}"
          class="@yield('additional_services_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition">
          <i class="fa-solid fa-hand-holding-dollar"></i>
          <span>Services</span>
        </a>
        <a href="{{ route('admin.pengguna.index') }}"
          class="@yield('pengguna_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition">
          <i class="fas fa-users"></i>
          <span>Pengguna</span>
        </a>
        <a href="{{ route('admin.pegawai.index') }}"
          class="@yield('pegawai_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition">
          <i class="fa-solid fa-clipboard-user"></i>
          <span>Pegawai</span>
        </a>
        <a href="{{ route('admin.pesanan.index') }}"
          class="@yield('pesanan_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition">
          <i class="fas fa-file-invoice"></i>
          <span>Pesanan</span>
        </a>
        <a href="{{ route('admin.task.index') }}"
          class="@yield('task_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition">
          <i class="fa-solid fa-clipboard-check"></i>
          <span>Assign Task</span>
        </a>
        <a href="{{ route('admin.report.index') }}"
          class="@yield('report_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition">
          <i class="fa-solid fa-clipboard-check"></i>
          <span>Laporan User</span>
        </a>
        <a href="{{ route('admin.profile.index') }}"
          class="@yield('profile_active') flex items-center space-x-3 p-3 hover:bg-gray-800 rounded-lg transition">
          <i class="fas fa-user"></i>
          <span>Profil</span>
        </a>
      </nav>
    </div>

    <div class="flex-1 flex flex-col">
      <div class="bg-white shadow p-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
        <div class="text-2xl font-bold text-gray-800" id="jam"></div>
      </div>

      <div class="flex-1 overflow-auto p-6 bg-slate-200/75">
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
        i = "0" + i
      };
      return i;
    }
  </script>
</body>

</html>
