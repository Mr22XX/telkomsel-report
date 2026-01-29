@extends('layouts.manager')

@section('title','Dashboard Manager')
@section('page-title','Dashboard Manager')

@section('content')

<!-- SUMMARY -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

<div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow">
<p>Total Report Hari Ini</p>
<p class="text-3xl font-bold">{{ $totalReport }}</p>
</div>

<div class="bg-white rounded-2xl shadow p-6 border-l-4 border-red-500">
<p>Total (Qty) Hari Ini</p>
<p class="text-3xl font-bold">{{ $totalQty }}</p>
</div>

<div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">
<p>Total (Rupiah) Hari Ini</p>
<p class="text-3xl font-bold text-green-600">
Rp {{ number_format($totalRevenue,0,',','.') }}
</p>
</div>

<div class="bg-white rounded-2xl shadow p-6 border-l-4 border-blue-500">
<p>Jumlah Sales Aktif</p>
<p class="text-3xl font-bold">{{ $ranking->count() }}</p>
</div>

</div>

<!-- CHART + RANKING -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

<!-- Chart -->
<div class="bg-white rounded-2xl shadow p-6">
<h2 class="font-semibold mb-4">Grafik Penjualan Bulanan</h2>
<canvas id="monthlyChart"></canvas>
</div>

<!-- Ranking -->
<div class="bg-white rounded-2xl shadow p-6">
<h2 class="font-semibold mb-4">Ranking Sales (5)</h2>

<table class="w-full text-sm">
<thead class="bg-gray-100">
<tr>
<th class="p-2">Rank</th>
<th>Nama</th>
<th>Total (Qty)</th>
<th>Total (Rupiah)</th>
</tr>
</thead>
<tbody>
@foreach($ranking as $i=>$r)
<tr class="border-b">
<td class="p-2">{{ $i+1 }}</td>
<td>{{ $r->name }}</td>
<td>{{ $r->total_qty}}</td>
<td>Rp {{ number_format($r->total_revenue,0,',','.') }}</td>
</tr>
@endforeach
</tbody>
</table>

</div>

</div>

@endsection

@push('scripts')
<script>
const monthlyCtx = document.getElementById('monthlyChart');

if(monthlyCtx){
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [
                {
                    label: 'Total Qty',
                    data: {!! json_encode($monthlyQtyTotals) !!},
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Total Revenue',
                    data: {!! json_encode($monthlyRevenueTotals) !!},
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {position: 'top'}
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
</script>
@endpush

