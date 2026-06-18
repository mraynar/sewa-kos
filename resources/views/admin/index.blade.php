@extends('admin.layouts.app')

@section('dashboard_active', 'active')
@section('content')
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border border-gray-50">
      <div class="flex justify-between items-center text-left">
        <div>
          <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Properti</p>
          <p class="text-2xl font-bold text-gray-900">{{ $properti->count() }} Kamar</p>
        </div>
        <i class="fas fa-home text-3xl text-blue-500 opacity-20"></i>
      </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border border-gray-50">
      <div class="flex justify-between items-center text-left">
        <div>
          <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Pengguna</p>
          <p class="text-2xl font-bold text-gray-900">{{ $user->count() }} User</p>
        </div>
        <i class="fas fa-users text-3xl text-green-500 opacity-20"></i>
      </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border border-gray-50">
      <div class="flex justify-between items-center text-left">
        <div>
          <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Pesanan</p>
          <p class="text-2xl font-bold text-gray-900">{{ $booking->count() }} Pesanan</p>
        </div>
        <i class="fas fa-shopping-cart text-3xl text-yellow-500 opacity-20"></i>
      </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border border-gray-50">
      <div class="flex justify-between items-center text-left">
        <div>
          <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Pendapatan</p>
          <p class="text-2xl font-bold text-gray-900">Rp{{ number_format($total_pendapatan, 0, ',', '.') }}</p>
        </div>
        <i class="fas fa-wallet text-3xl text-red-500 opacity-20"></i>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6 flex flex-col">
      <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-900">Tren Pemasukan</h3>
        <form id="filterForm" method="GET" class="flex gap-1 bg-gray-100 p-1 rounded-lg border border-gray-200">
          <button type="submit" name="filter_type" value="week"
            class="px-3 py-1.5 text-[10px] font-bold uppercase rounded-md transition-all {{ $filter_type == 'week' ? 'bg-white shadow text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">Mingguan</button>
          <button type="submit" name="filter_type" value="month"
            class="px-3 py-1.5 text-[10px] font-bold uppercase rounded-md transition-all {{ $filter_type == 'month' ? 'bg-white shadow text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">Bulanan</button>
          <button type="submit" name="filter_type" value="year"
            class="px-3 py-1.5 text-[10px] font-bold uppercase rounded-md transition-all {{ $filter_type == 'year' ? 'bg-white shadow text-blue-600' : 'text-gray-400 hover:text-gray-600' }}">Tahunan</button>
        </form>
      </div>
      <div
        class="flex-grow bg-gray-200/50 border border-gray-100 rounded-2xl flex items-center justify-center min-h-[400px]">
        <div id="line-chart" class="w-full px-2"></div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 flex flex-col">
      <h3 class="text-lg font-bold text-gray-900 mb-6 text-left">Statistik Properti</h3>
      <div
        class="flex-grow bg-gray-200/50 border border-gray-100 rounded-2xl flex items-center justify-center min-h-[400px]">
        <div id="pie-chart"></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    // Ambil data dari Controller menggunakan direktif json Laravel
    const chartData = @json($chart_data);
    const chartCategories = @json($chart_categories);

    const lineChart = new ApexCharts(document.querySelector("#line-chart"), {
      series: [{
        name: "Pendapatan",
        data: chartData // Diisi variabel chartData
      }],
      chart: {
        type: "line",
        height: 350,
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        }
      },
      colors: ["#2563eb"],
      stroke: {
        curve: "smooth",
        width: 4
      },
      markers: {
        size: 4,
        colors: ["#2563eb"],
        strokeColors: "#fff",
        strokeWidth: 2
      },
      xaxis: {
        categories: chartCategories, // Diisi variabel chartCategories
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        labels: {
          formatter: (v) => "Rp" + v.toLocaleString('id-ID')
        }
      },
      tooltip: {
        theme: "dark",
        y: {
          formatter: (v) => "Rp" + v.toLocaleString('id-ID')
        }
      },
      grid: {
        borderColor: "#f1f1f1",
        strokeDashArray: 4
      }
    });

    // Data untuk Pie Chart
    const sisaData = @json($pie_sisa);
    const pieSeries = @json($pie_series);
    const pieLabels = @json($pie_labels);

    const pieChart = new ApexCharts(document.querySelector("#pie-chart"), {
      series: pieSeries, // Diisi variabel pieSeries
      labels: pieLabels, // Diisi variabel pieLabels
      chart: {
        type: "pie",
        width: 400
      },
      colors: ["#0f172a", "#f59e0b", "#10b981", "#3b82f6"],
      legend: {
        position: 'bottom',
        fontSize: '12px',
        fontWeight: 600
      },
      dataLabels: {
        enabled: true,
        style: {
          fontSize: '14px',
          fontWeight: 'bold'
        }
      },
      tooltip: {
        theme: "dark",
        custom: function({
          series,
          seriesIndex,
          dataPointIndex,
          w
        }) {
          return '<div class="px-3 py-2 bg-gray-800">' +
            '<span class="font-bold">' + w.config.labels[seriesIndex] + '</span>' +
            '<div class="text-xs mt-1">Total Pesanan: ' + series[seriesIndex] + ' Booking</div>' +
            '</div>';
        }
      }
    });

    lineChart.render();
    pieChart.render();
  </script>
@endsection
