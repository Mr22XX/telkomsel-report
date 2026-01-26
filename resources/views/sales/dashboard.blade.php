@extends('layouts.sales')

@section('title', 'Dashboard Sales')
@section('page-title', 'Dashboard')

@section('content')




<!-- SUMMARY -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

    <!-- Total Report -->
    <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-2xl shadow-lg p-6">
        <p class="text-sm opacity-80">Total Report Hari Ini</p>
        <p class="text-4xl font-bold mt-2">
            {{ $totalReport }}
        </p>
    </div>

    <!-- Total Qty -->
    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-red-500">
        <p class="text-gray-500 text-sm">Total Penjualan Hari Ini (Qty)</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">
            {{ $totalQty }} <span class="text-sm text-gray-400">Unit</span>
        </p>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">
        <p class="text-gray-500 text-sm">Total Penjualan Hari Ini (Rupiah)</p>
        <p class="text-3xl font-bold text-green-600 mt-2">
            Rp {{ number_format($totalRevenue,0,',','.') }}
        </p>
    </div>

</div>


<!-- CHART -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- QTY CHART -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-gray-700">
                Produk Terjual (Qty)
            </h2>
            <span class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-full">
                Hari Ini
            </span>
        </div>
        <div class="relative h-[280px]">
            <canvas id="qtyChart"></canvas>
        </div>
    </div>

    <!-- REVENUE CHART -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-gray-700">
                Produk Terjual (Revenue)
            </h2>
            <span class="text-xs bg-green-100 text-green-600 px-3 py-1 rounded-full">
                Hari Ini
            </span>
        </div>
        <div class="relative h-[280px]">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

</div>



@endsection

@push('scripts')
<script>
/* =====================
   CHART PENJUALAN HARI INI
===================== */
const qtyCtx = document.getElementById('qtyChart');

new Chart(qtyCtx, {
    type: 'bar',
    data: {
        labels: ['Perdana','ByU','Lite','Orbit'],
        datasets: [{
            label: 'Qty',
            data: [
                {{ $chartQty['perdana'] }},
                {{ $chartQty['byu'] }},
                {{ $chartQty['lite'] }},
                {{ $chartQty['orbit'] }}
            ],
            backgroundColor: '#dc2626',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } }
        }
    }
});



const revenueCtx = document.getElementById('revenueChart');

new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: ['CVM ByU','Super Seru','Digital','Roaming','VF HP','VF Lite','Lite VF','ByU VF','MyTelkomsel'],
        datasets: [{
            label: 'Rupiah (Rp)',
            data: [
                {{ $chartRevenue['cvm_byu'] }},
                {{ $chartRevenue['super_seru'] }},
                {{ $chartRevenue['digital'] }},
                {{ $chartRevenue['roaming'] }},
                {{ $chartRevenue['vf_hp'] }},
                {{ $chartRevenue['vf_lite_byu'] }},
                {{ $chartRevenue['lite_vf'] }},
                {{ $chartRevenue['byu_vf'] }},
                {{ $chartRevenue['my_telkomsel'] }}
            ],
            backgroundColor: '#16a34a',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
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
        datasets: [
        {
            label: 'Total Qty',
            data: {!! json_encode($monthlyQtyTotals) !!},
            borderColor: '#dc2626',
            fill: false,
            tension: 0.4
        },
        {
            label: 'Total Revenue (Rp)',
            data: {!! json_encode($monthlyRevenueTotals) !!},
            borderColor: '#16a34a',
            fill: false,
            tension: 0.4
        }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

</script>
@endpush


