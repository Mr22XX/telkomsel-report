@extends('layouts.manager')

@section('title','Monitoring Sales')
@section('page-title','Monitoring Sales')

@section('content')

<style>
table.dataTable {
    border-collapse: collapse !important;
    width: 100% !important;
}

table.dataTable thead th {
    background-color: #f9fafb;
    color: #374151;
    font-weight: 600;
    padding: 12px 10px;
    border-bottom: 1px solid #e5e7eb;
}

table.dataTable tbody td {
    padding: 12px 10px;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: top;
}

.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 6px 10px;
    margin-left: 6px;
}

.dataTables_wrapper .dt-buttons button {
    background-color: #1f67e4 !important;
    color: white !important;
    border-radius: 6px !important;
    padding: 6px 12px !important;
    margin-right: 6px;
    font-size: 13px;
}

.dataTables_wrapper .dt-buttons button:hover {
    background-color: #1c55b9 !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 4px 10px !important;
}
</style>

<div class="bg-white rounded-xl shadow p-6">

<h2 class="text-lg font-semibold mb-4">Monitoring Laporan Harian Sales</h2>

<table id="monitoringTable" class="w-full text-sm border display nowrap">
<thead class="bg-gray-100">
<tr>
    <th>No</th>
    <th>Nama Sales</th>
    <th>Tanggal</th>
    <th>Status Laporan</th>
    <th>Total Qty</th>
    <th>Total Revenue</th>
</tr>
</thead>
<tbody>

@foreach($sales as $i => $s)
@php

    $reportToday = $s->reports->first();

    $totalQty = $s->reports->sum(fn($r) =>
        $r->perdana + $r->byu + $r->lite + $r->orbit
    );

    $totalRevenue = $s->reports->sum(fn($r) =>
        $r->cvm_byu +
        $r->super_seru +
        $r->digital +
        $r->roaming +
        $r->vf_hp +
        $r->vf_lite_byu +
        $r->lite_vf +
        $r->byu_vf +
        $r->my_telkomsel
    );
@endphp

<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $s->name }}</td>
    <td>{{ $reportToday ? \Carbon\Carbon::parse($reportToday->tanggal)->format('d-m-Y') : '-' }}</td>
    <td>
        @if($s->reports->count() > 0)
            <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">Sudah Input</span>
        @else
            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs">Belum Input</span>
        @endif
    </td>
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
    $('#monitoringTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Monitoring Sales {{ now()->format("Y-m-d") }}'
            },
            {
                extend: 'pdfHtml5',
                title: 'Monitoring Sales {{ now()->format("Y-m-d") }}',
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                title: 'Monitoring Sales {{ now()->format("Y-m-d") }}'
            }
        ],
        pageLength: 10,
        lengthMenu: [5,10,25,50],
        responsive: true
    });
});
</script>
@endpush
