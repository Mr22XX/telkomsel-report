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

    @if(session('success'))
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        timer: 2000,
        showConfirmButton: true
    });
    </script>
    @endif

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
                    <th>Quantity</th>
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
                    <td class="font-semibold"
                        data-perdana="{{ $r->perdana }}"
                        data-byu="{{ $r->byu }}"
                        data-lite="{{ $r->lite }}"
                        data-orbit="{{ $r->orbit }}">
                    <button
                    class="underline text-red-600"
                    onclick="openDetailModal1({
                        perdana: '{{ $r->perdana }}',
                        byu: '{{ $r->byu }}',
                        lite: '{{ $r->lite }}',

                        sp_telkom: '{{ $r->sp_telkom }}',
                        orbit_n1: '{{ $r->orbit_n1 }}',
                        orbit_n2: '{{ $r->orbit_n2 }}',
                        orbit_n2_new: '{{ $r->orbit_n2_new }}',
                        orbit_h2: '{{ $r->orbit_h2 }}',
                        orbit_h2_np01: '{{ $r->orbit_h2_np01 }}',
                        orbit_h3: '{{ $r->orbit_h3 }}',
                    })">

                    {{ $r->totalQty() }}
                    </button>

                    </td>
                    <td class="font-semibold"
                    data-cvm="{{ $r->cvm_byu }}"
                    data-super="{{ $r->super_seru }}"
                    data-digital="{{ $r->digital }}"
                    data-roaming="{{ $r->roaming }}"
                    data-vfhp="{{ $r->vf_hp }}"
                    data-vflite="{{ $r->vf_lite_byu }}"
                    data-litevf="{{ $r->lite_vf }}"
                    data-byuvf="{{ $r->byu_vf }}"
                    data-mytel="{{ $r->my_telkomsel }}">
                        <button
                            class="underline text-red-600"
                            onclick="openDetailModal2({
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
                            Rp {{ number_format($r->totalRevenue(), 0, ',', '.') }}
                        </button>
                    </td>
                    <td class="space-x-3 whitespace-nowrap">
                        <a href="{{ route('reports.edit', $r->id) }}"
                        class="text-blue-600 hover:text-blue-800">
                        <i class="fa-regular fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('reports.destroy', $r->id) }}"
                            method="POST"
                            class="inline delete-form"
                            >
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fa-solid fa-trash"></i>
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
<div id="detailModal1"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">
                Detail Quantity
            </h2>
            <button onclick="closeDetailModal1()" class="text-gray-400 hover:text-gray-600">
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

            <!-- ORBIT ACCORDION -->
            <li>
                <button onclick="toggleOrbitDetail()"
                    class="w-full flex justify-between items-center text-left font-semibold text-red-600 underline">
                    <span>Orbit (Total)</span>
                    <span id="detailOrbitTotal"></span>
                </button>

                <div id="orbitDetailBody" class="hidden mt-2 pl-3 space-y-1 text-sm border-l">

                    <div class="flex justify-between">
                        <span>SP Telkomsel Lite</span>
                        <span id="detailSpTelkom"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Orbit N1</span>
                        <span id="detailOrbitN1"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Orbit Star N2</span>
                        <span id="detailOrbitN2"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Orbit Star N2 (New)</span>
                        <span id="detailOrbitN2New"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Orbit Star H2</span>
                        <span id="detailOrbitH2"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Orbit Star H2 (Np-01)</span>
                        <span id="detailOrbitH2Np01"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Orbit Star H3</span>
                        <span id="detailOrbitH3"></span>
                    </div>

                </div>
            </li>

        </ul>

        <div class="mt-6 text-right">
            <button onclick="closeDetailModal1()"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PENJUALAN -->
<div id="detailModal2"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">
                Detail Penjualan
            </h2>
            <button onclick="closeDetailModal2()" class="text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>

        <ul class="space-y-2 text-sm">
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
            <button onclick="closeDetailModal2()"
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
    title: 'Laporan Penjualan',
    customizeData: function (data) {

        // HEADER BARU
        data.header = [
            "Tanggal","TAP","Fokus",
            "Perdana","Byu","Lite","Orbit",
            "CVM ByU","Super Seru","Digital","Roaming",
            "VF HP","VF Lite ByU","Lite VF","ByU VF","MyTelkomsel"
        ];

        let newBody = [];

        data.body.forEach(function(row){

            let qtyCell = row[3];
            let totalCell = row[4];

            let nodeQty   = $(table.cell({row: data.body.indexOf(row), column: 3}).node());
            let nodeTotal = $(table.cell({row: data.body.indexOf(row), column: 4}).node());

            newBody.push([
                row[0], // tanggal
                row[1], // tap
                row[2], // fokus

                nodeQty.data('perdana') * 35000,
                nodeQty.data('byu') * 35000,
                nodeQty.data('lite') * 35000,
                nodeQty.data('orbit'),

                nodeTotal.data('cvm'),
                nodeTotal.data('super'),
                nodeTotal.data('digital'),
                nodeTotal.data('roaming'),
                nodeTotal.data('vfhp'),
                nodeTotal.data('vflite'),
                nodeTotal.data('litevf'),
                nodeTotal.data('byuvf'),
                nodeTotal.data('mytel'),
            ]);
        });

                data.body = newBody;
            }
        },
        {
    extend: 'pdfHtml5',
    title: 'Laporan Penjualan',
    orientation: 'landscape',
    pageSize: 'A4',
    customize: function (doc) {

        let newHeader = [
            "Tanggal","TAP","Fokus",
            "Perdana","Byu","Lite","Orbit",
            "CVM ByU","Super Seru","Digital","Roaming",
            "VF HP","VF Lite ByU","Lite VF","ByU VF","MyTelkomsel"
        ];

        let body = doc.content[1].table.body;
        let newBody = [];

        // header baru
        newBody.push(newHeader);

        for (let i = 1; i < body.length; i++) {

            let nodeQty   = $(table.cell({row: i-1, column: 3}).node());
            let nodeTotal = $(table.cell({row: i-1, column: 4}).node());

            newBody.push([
                body[i][0].text || '',
                body[i][1].text || '',
                body[i][2].text || '',

                nodeQty.data('perdana') || '0',
                nodeQty.data('byu') || '0',
                nodeQty.data('lite') || '0',
                nodeQty.data('orbit') || '0',

                nodeTotal.data('cvm') || '0',
                nodeTotal.data('super') || '0',
                nodeTotal.data('digital') || '0',
                nodeTotal.data('roaming') || '0',
                nodeTotal.data('vfhp') || '0',
                nodeTotal.data('vflite') || '0',
                nodeTotal.data('litevf') || '0',
                nodeTotal.data('byuvf') || '0',
                nodeTotal.data('mytel') || '0'
            ]);
        }

        doc.content[1].table.body = newBody;

        // font kecil agar muat
        doc.defaultStyle.fontSize = 7;

        // semua kolom auto width
        doc.content[1].table.widths = Array(newHeader.length).fill('*');

        // center title
        doc.styles.title = {
            alignment: 'center',
            fontSize: 12,
            bold: true
        };
    }
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
function openDetailModal1(data) {

    document.getElementById('detailPerdana').innerText = data.perdana;
    document.getElementById('detailByu').innerText = data.byu;
    document.getElementById('detailLite').innerText = data.lite;

    // total orbit pcs (belum dikali harga)
    let orbitTotal =
        parseInt(data.sp_telkom) +
        parseInt(data.orbit_n1) +
        parseInt(data.orbit_n2) +
        parseInt(data.orbit_n2_new) +
        parseInt(data.orbit_h2) +
        parseInt(data.orbit_h2_np01) +
        parseInt(data.orbit_h3);

    document.getElementById('detailOrbitTotal').innerText = orbitTotal;

    // detail orbit
    document.getElementById('detailSpTelkom').innerText = data.sp_telkom;
    document.getElementById('detailOrbitN1').innerText = data.orbit_n1;
    document.getElementById('detailOrbitN2').innerText = data.orbit_n2;
    document.getElementById('detailOrbitN2New').innerText = data.orbit_n2_new;
    document.getElementById('detailOrbitH2').innerText = data.orbit_h2;
    document.getElementById('detailOrbitH2Np01').innerText = data.orbit_h2_np01;
    document.getElementById('detailOrbitH3').innerText = data.orbit_h3;

    const modal = document.getElementById('detailModal1');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}


function toggleOrbitDetail() {
    const body = document.getElementById('orbitDetailBody');
    body.classList.toggle('hidden');
}



function closeDetailModal1() {
    const modal = document.getElementById('detailModal1');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
function openDetailModal2(data) {
   const rupiah = (angka) =>
        new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(angka);

    document.getElementById('detailCvmByu').innerText = rupiah(data.cvm_byu);
    document.getElementById('detailSuper').innerText = rupiah(data.super_seru);
    document.getElementById('detailDigital').innerText = rupiah(data.digital);
    document.getElementById('detailRoaming').innerText = rupiah(data.roaming);
    document.getElementById('detailVfhp').innerText = rupiah(data.vf_hp);
    document.getElementById('detailVflitebyu').innerText = rupiah(data.vf_lite_byu);
    document.getElementById('detailLitevf').innerText = rupiah(data.lite_vf);
    document.getElementById('detailByuvf').innerText = rupiah(data.byu_vf);
    document.getElementById('detailMytelkomsel').innerText = rupiah(data.mytelkomsel);


    const modal = document.getElementById('detailModal2');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDetailModal2() {
    const modal = document.getElementById('detailModal2');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin hapus data?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
  


@endpush
