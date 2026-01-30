@extends('layouts.sales')

@section('title', 'Dashboard Sales')
@section('page-title', 'Dashboard Bulanan')

@section('content')

<!-- SUMMARY -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

    <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-2xl shadow-lg p-5">
        <p class="text-sm opacity-80">Total Report</p>
        <p class="text-3xl font-bold mt-2">{{ $totalReport }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-500">
        <p class="text-gray-500 text-sm">Revenue Bulan Ini</p>
        <p class="text-2xl font-bold text-green-600 mt-2">
            Rp {{ number_format($totalRevenue,0,',','.') }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-500">
        <p class="text-gray-500 text-sm">Revenue Hari Ini</p>
        <p class="text-2xl font-bold text-blue-600 mt-2">
            Rp {{ number_format($todayRevenue,0,',','.') }}
        </p>
    </div>

  

</div>


<div class="bg-white rounded-2xl shadow-lg p-4">
    <h2 class="font-semibold text-gray-700 mb-3">
        Grafik Total Penjualan per Bulan (Rupiah)
    </h2>
    <div class="relative h-[220px]">
        <canvas id="monthlyRevenueChart"></canvas>
    </div>
</div>



@endsection


@push('scripts')
<script>
const ctx = document.getElementById('monthlyRevenueChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyLabels) !!},
        datasets: [{
            label: 'Total Revenue (Rp)',
            data: {!! json_encode($monthlyRevenueTotals) !!},
            borderColor: '#16a34a',
            backgroundColor: 'rgba(22,163,74,0.15)',
            fill: true,
            tension: 0.4,
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => 'Rp ' + value.toLocaleString('id-ID')
                }
            }
        }
    }
});
</script>
@endpush


