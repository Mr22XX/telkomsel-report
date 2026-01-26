@extends('layouts.manager')

@section('title','Rekap Laporan Sales')
@section('page-title','Rekap Laporan Sales')

@section('content')

<style>
.dataTables_wrapper .dt-buttons button {
    background:#2563eb !important;
    color:white !important;
    border-radius:8px !important;
    padding:6px 14px !important;
    margin-right:6px;
}
.dataTables_wrapper .dt-buttons button:hover {
    background:#1d4ed8 !important;
}
</style>

<div class="bg-white rounded-2xl shadow p-6">

<!-- FILTER -->
<form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div>
        <label class="text-sm text-gray-600">Tanggal Mulai</label>
        <input type="date" name="start_date" value="{{ $startDate }}"
            class="w-full border rounded-lg p-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Tanggal Akhir</label>
        <input type="date" name="end_date" value="{{ $endDate }}"
            class="w-full border rounded-lg p-2">
    </div>

    <div>
        <label class="text-sm text-gray-600">Nama Sales</label>
        <input type="text" name="sales" value="{{ $salesName }}"
            placeholder="Cari sales..."
            class="w-full border rounded-lg p-2">
    </div>

    <div class="flex items-end gap-2">
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Filter
        </button>
        <a href="{{ route('manager.rekap') }}"
           class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
            Reset
        </a>
    </div>
</form>

<!-- TABLE -->
<table id="rekapTable" class="w-full text-sm display nowrap">
<thead class="bg-gray-100">
<tr>
    <th>No</th>
    <th>Nama Sales</th>
    <th>Tanggal</th>
    <th>Total Qty</th>
    <th>Total Revenue</th>
</tr>
</thead>
<tbody>

@foreach($reports as $i=>$r)
@php
$totalQty = $r->perdana + $r->byu + $r->lite + $r->orbit;

$totalRevenue =
    $r->cvm_byu +
    $r->super_seru +
    $r->digital +
    $r->roaming +
    $r->vf_hp +
    $r->vf_lite_byu +
    $r->lite_vf +
    $r->byu_vf +
    $r->my_telkomsel;
@endphp

<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $r->user->name }}</td>
    <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
    <td>{{ $totalQty }}</td>
    <td>Rp {{ number_format($totalRevenue,0,',','.') }}</td>
</tr>
@endforeach

</tbody>
</table>

</div>

@endsection


@push('scripts')
<script>
$(document).ready(function() {
    $('#rekapTable').DataTable({
        dom: 'Brtip',
        buttons: [
            { extend: 'excelHtml5', title: 'Rekap Sales' },
            { extend: 'pdfHtml5', orientation:'landscape', pageSize:'A4', title:'Rekap Sales' },
            { extend: 'print', title:'Rekap Sales' }
        ],
        pageLength: 50,
        responsive:true
    });
});
</script>
@endpush
