@extends('layouts.sales')

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


<div class="mb-6 space-y-4">

    <h1 class="text-xl font-bold text-gray-800">
        Report Penjualan
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 items-end">

        <!-- START DATE -->
        <div>
            <label class="text-xs text-gray-500">Tanggal Mulai</label>
            <input type="date" id="startDate"
                class="border rounded-lg px-3 py-2 text-sm w-full">
        </div>

        <!-- END DATE -->
        <div>
            <label class="text-xs text-gray-500">Tanggal Akhir</label>
            <input type="date" id="endDate"
                class="border rounded-lg px-3 py-2 text-sm w-full">
        </div>

        <!-- FILTER -->
        <div>
            <button id="filterDate"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm w-full">
                Filter
            </button>
        </div>

        <!-- RESET -->
        <div>
            <button id="resetDate"
                class="border px-4 py-2 bg-white rounded-lg text-sm hover:bg-gray-100 w-full">
                Reset
            </button>
        </div>

        <!-- TAMBAH DATA -->
        <div class="lg:col-span-2 lg:text-right">
            <a href="{{ route('reports.create') }}"
               class="inline-block bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow text-sm
                      w-full lg:w-auto text-center">
                + Tambah Data
            </a>
        </div>

    </div>

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
                        <button
                            class="underline text-red-600"
                            onclick="openDetailModal({
                                perdana: '{{ $r->perdana }}',
                                byu: '{{ $r->byu }}',
                                lite: '{{ $r->lite }}',
                                orbit: '{{ $r->orbit }}',
                                cvm_byu: '{{ $r->cvm_byu }}',
                                super_seru: '{{ $r->super_seru }}',
                                digital: '{{ $r->digital }}',
                                roaming: '{{ $r->roaming }}',
                                vf_hp: '{{ $r->vf_hp }}',
                                vf_lite_byu: '{{ $r->vf_lite_byu }}',
                                lite_vf: '{{ $r->lite_vf }}',
                                byu_vf: '{{ $r->byu_vf }}',
                                mytelkomsel: '{{ $r->my_telkomsel }}',
                            })">
                            {{ $r->totalSelling() }}
                        </button>
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


<!-- MODAL DETAIL PENJUALAN -->
<div id="detailModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">
                Detail Penjualan
            </h2>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>

        <ul class="space-y-2 text-sm">
            <li class="flex justify-between">
                <span>Perdana</span>
                <span id="detailPerdana" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Byu</span>
                <span id="detailByu" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Lite</span>
                <span id="detailLite" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Orbit</span>
                <span id="detailOrbit" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Cvm Byu</span>
                <span id="detailCvmByu" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Super Seru</span>
                <span id="detailSuper" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Digital</span>
                <span id="detailDigital" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Roaming</span>
                <span id="detailRoaming" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Vf Hp</span>
                <span id="detailVfhp" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Vf Lite Byu</span>
                <span id="detailVflitebyu" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Lite Vf</span>
                <span id="detailLitevf" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>Byu Vf</span>
                <span id="detailByuvf" class="font-semibold"></span>
            </li>
            <li class="flex justify-between">
                <span>My Telkomsel</span>
                <span id="detailMytelkomsel" class="font-semibold"></span>
            </li>
        </ul>

        <div class="mt-6 text-right">
            <button onclick="closeDetailModal()"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                Tutup
            </button>
        </div>
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

        let rowDate = data[0].match(/\d{4}-\d{2}-\d{2}/)?.[0];

        if (!rowDate) return true;

        if (start && rowDate < start) return false;
        if (end && rowDate > end) return false;

        return true;
    });





    let table = $('#reportTable').DataTable({
        responsive: true,
        pageLength : 10,
        scrollX: false,
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

<script>
function openDetailModal(data) {
    document.getElementById('detailPerdana').innerText = data.perdana;
    document.getElementById('detailByu').innerText = data.byu;
    document.getElementById('detailLite').innerText = data.lite;
    document.getElementById('detailOrbit').innerText = data.orbit;
    document.getElementById('detailCvmByu').innerText = data.cvm_byu;
    document.getElementById('detailSuper').innerText = data.super_seru;
    document.getElementById('detailDigital').innerText = data.digital;
    document.getElementById('detailRoaming').innerText = data.roaming;
    document.getElementById('detailVfhp').innerText = data.vf_hp;
    document.getElementById('detailVflitebyu').innerText = data.vf_lite_byu;
    document.getElementById('detailLitevf').innerText = data.lite_vf;
    document.getElementById('detailByuvf').innerText = data.byu_vf;
    document.getElementById('detailMytelkomsel').innerText = data.mytelkomsel;

    const modal = document.getElementById('detailModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDetailModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>


@endpush
