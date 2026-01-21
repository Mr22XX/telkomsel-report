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
<div class="bg-white rounded-xl shadow p-6">
    <h2 class="font-semibold text-gray-700 mb-4">
        Penjualan Hari Ini
    </h2>

    <div class="relative h-[260px] sm:h-[300px] md:h-[260px] lg:h-[300px]">
    <canvas id="salesChart"></canvas>
    </div>

</div>

@endsection

@push('scripts')
<script>
const ctx = document.getElementById('salesChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Perdana', 'ByU', 'Lite', 'Orbit', 'cvm_byu', 'superseru' , 'roaming',  'Digital', 'mytelkomsel'],
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
            backgroundColor: [
                '#dc2626',
                '#ef4444',
                '#f87171',
                '#fb7185',
                '#fdba74'
            ],
            borderRadius: 6,
            barThickness: 'flex',
            maxBarThickness: 40
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>
@endpush

