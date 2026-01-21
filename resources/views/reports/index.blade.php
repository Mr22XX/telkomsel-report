@extends('layouts.sales')

@section('content')

<style>
/* FIX DATATABLE + TAILWIND */
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
    background-color: #dc2626 !important;
    color: white !important;
    border-radius: 6px !important;
    padding: 6px 12px !important;
    margin-right: 6px;
    font-size: 13px;
}

.dataTables_wrapper .dt-buttons button:hover {
    background-color: #b91c1c !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 4px 10px !important;
}
</style>


<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h1 class="text-xl font-bold text-gray-800">
        Data Report Penjualan
    </h1>

    <div class="flex flex-col md:flex-row gap-4 items-end">

        <div>
            <label class="text-xs text-gray-500">Tanggal Mulai</label>
            <input type="date" id="startDate"
                   class="border rounded-lg px-3 py-2 text-sm w-full">
        </div>

        <div>
            <label class="text-xs text-gray-500">Tanggal Akhir</label>
            <input type="date" id="endDate"
                   class="border rounded-lg px-3 py-2 text-sm w-full">
        </div>

        <button id="filterDate"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
            Filter
        </button>

        <button id="resetDate"
                class="border px-4 py-2 bg-white rounded-lg text-sm hover:bg-gray-100">
            Reset
        </button>

    </div>

    {{-- Tambah data button --}}
    <a href="{{ route('reports.create') }}"
       class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow text-sm">
       + Tambah Data
    </a>


</div>

<div class="bg-white p-4 rounded-xl shadow">
    <div class="overflow-x-auto">
        <table id="reportTable" class="w-full text-sm">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>TAP</th>
                    <th>Fokus Selling</th>
                    <th>Total Penjualan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reports as $r)
                <tr>
                    <td>
                        <span class="hidden">{{ $r->tanggal }}</span>
                        {{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}
                    </td>
                    <td>{{ $r->tap }}</td>
                    <td class="text-xs">
                        <ol type="1" class="list-decimal list-inside space-y-1"> 
                            <li>
                                {{ $r->fokus_1 }}
                            </li>
                            <li>
                                {{ $r->fokus_2 }}
                            </li>
                            <li>
                                {{ $r->fokus_3 }}
                            </li>
                        </ol>
                    </td>
                    <td class="font-semibold">
                        {{ $r->totalSelling() }}
                    </td>
                    <td class="space-x-3 whitespace-nowrap">
                        <a href="{{ route('reports.edit', $r->id) }}"
                        class="text-blue-600 hover:underline">
                        Edit
                        </a>

                        <form action="{{ route('reports.destroy', $r->id) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

        // CUSTOM FILTER TANGGAL
       $.fn.dataTable.ext.search.push(function (settings, data) {

        let start = $('#startDate').val(); // YYYY-MM-DD
        let end   = $('#endDate').val();   // YYYY-MM-DD

        // Ambil tanggal RAW dari kolom pertama
        // hasilnya: "2026-01-21"
        let rowDate = data[0].match(/\d{4}-\d{2}-\d{2}/)?.[0];

        if (!rowDate) return true;

        if (start && rowDate < start) return false;
        if (end && rowDate > end) return false;

        return true;
    });





    let table = $('#reportTable').DataTable({
        responsive: true,
        pageLength : 10,
        scrollX: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Report Penjualan',
                exportOptions: { columns: [0,1,2,3] }
            },
            {
                extend: 'pdfHtml5',
                title: 'Report Penjualan',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: { columns: [0,1,2,3] }
            },
            {
                extend: 'print',
                title: 'Report Penjualan',
                exportOptions: { columns: [0,1,2,3] }
            }
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                next: "›",
                previous: "‹"
            }
        }
    });

    // BUTTON FILTER
    $('#filterDate').on('click', function () {
        table.draw();
    });

    // BUTTON RESET
    $('#resetDate').on('click', function () {
        $('#startDate').val('');
        $('#endDate').val('');
        table.draw();
    });

});
</script>

@endpush
