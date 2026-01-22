@extends('layouts.sales')

@section('title', 'Dashboard Sales')
@section('page-title', 'Dashboard')

@section('content')

<!-- SUMMARY -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500 text-sm">Total Report</p>
        <p class="text-3xl font-bold text-red-600">
            {{ $totalReport }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500 text-sm">Total Penjualan Hari Ini</p>
        <p class="text-3xl font-bold text-red-600">
            {{ $totalSellingToday }}
        </p>
    </div>

</div>

<!-- CHART -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- CHART Produk -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-semibold text-gray-700 mb-4">
            Produk Terjual
        </h2>

        <div class="relative h-[260px] sm:h-[300px]">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- CHART BULANAN -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-semibold text-gray-700 mb-4">
            Total Penjualan per Bulan
        </h2>

        <div class="relative h-[260px] sm:h-[300px]">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

</div>


@endsection

@push('scripts')
<script>
/* =====================
   CHART PENJUALAN HARI INI
===================== */
const ctx = document.getElementById('salesChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Perdana', 'ByU', 'Lite', 'Orbit', 'cvm_byu', 'superseru', 'roaming', 'Digital', 'mytelkomsel'],
        datasets: [{
            label: 'Jumlah Penjualan',
            data: [
                {{ $chartData['perdana'] }},
                {{ $chartData['byu'] }},
                {{ $chartData['lite'] }},
                {{ $chartData['orbit'] }},
                {{ $chartData['cvm_byu'] }},
                {{ $chartData['super_seru'] }},
                {{ $chartData['roaming'] }},
                {{ $chartData['digital'] }},
                {{ $chartData['my_telkomsel'] }}
            ],
            backgroundColor: '#dc2626',
            borderRadius: 6,
            maxBarThickness: 40
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } }
        }
    }
});


/* =====================
   CHART PENJUALAN BULANAN
===================== */
const monthlyCtx = document.getElementById('monthlyChart');

new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyLabels) !!},
        datasets: [{
            label: 'Total Penjualan',
            data: {!! json_encode($monthlyTotals) !!},
            borderColor: '#dc2626',
            backgroundColor: 'rgba(220, 38, 38, 0.15)',
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointBackgroundColor: '#dc2626'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endpush


