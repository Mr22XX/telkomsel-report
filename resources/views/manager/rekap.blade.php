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
    <th>Tap</th>
    <th>Fokus</th>
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
                    class="underline text-blue-600"
                    onclick="openDetailModal1({
                    perdana: '{{ $r->perdana }}',
                    byu: '{{ $r->byu }}',
                    lite: '{{ $r->lite }}',
                    orbit: '{{ $r->orbit }}',
                    })">

                    {{ $totalQty }}
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
                            class="underline text-blue-600"
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
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </button>
                    </td>
</tr>
@endforeach

</tbody>
</table>

</div>

{{-- Modal Section --}}
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
            <li class="flex justify-between">
                <span>Orbit</span>
                <span id="detailOrbit" class="font-semibold"></span>
            </li>
        </ul>

        <div class="mt-6 text-right">
            <button onclick="closeDetailModal1()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                Tutup
            </button>
        </div>
    </div>
</div>

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
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
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





    let table = $('#rekapTable').DataTable({
    responsive: true,
    pageLength: 20,
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            title: 'Laporan Penjualan',
            customizeData: function (data) {

                data.header = [
                    "Nama Sales","Tanggal","TAP","Fokus",
                    "Perdana","Byu","Lite","Orbit",
                    "CVM ByU","Super Seru","Digital","Roaming",
                    "VF HP","VF Lite ByU","Lite VF","ByU VF","MyTelkomsel"
                ];

                let newBody = [];

                data.body.forEach(function(row, index){

                    let nodeQty   = $(table.cell({row: index, column: 5}).node());
                    let nodeTotal = $(table.cell({row: index, column: 6}).node());

                    newBody.push([
                        row[1], // Nama Sales
                        row[2], // Tanggal
                        row[3], // TAP
                        row[4], // Fokus

                        nodeQty.data('perdana'),
                        nodeQty.data('byu'),
                        nodeQty.data('lite'),
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
    pageSize: 'A3', 
    customize: function (doc) {

        let newHeader = [
            "Nama Sales","Tanggal","TAP","Fokus",
            "Perdana","Byu","Lite","Orbit",
            "CVM ByU","Super Seru","Digital","Roaming",
            "VF HP","VF Lite ByU","Lite VF","ByU VF","MyTelkomsel"
        ];

        let body = doc.content[1].table.body;
        let newBody = [];
        newBody.push(newHeader);

        for (let i = 1; i < body.length; i++) {

            let nodeQty   = $(table.cell({row: i-1, column: 5}).node());
            let nodeTotal = $(table.cell({row: i-1, column: 6}).node());

            // ambil fokus dari <li> dan jadikan vertical
            let fokusList = [];
            $(table.cell({row: i-1, column: 4}).node()).find('li').each(function(){
                fokusList.push($(this).text());
            });
            let fokusText = fokusList.join("\n");

            newBody.push([
                body[i][1].text || '',
                body[i][2].text || '',
                body[i][3].text || '',
                fokusText,

                nodeQty.data('perdana') || 0,
                nodeQty.data('byu') || 0,
                nodeQty.data('lite') || 0,
                nodeQty.data('orbit') || 0,

                nodeTotal.data('cvm') || 0,
                nodeTotal.data('super') || 0,
                nodeTotal.data('digital') || 0,
                nodeTotal.data('roaming') || 0,
                nodeTotal.data('vfhp') || 0,
                nodeTotal.data('vflite') || 0,
                nodeTotal.data('litevf') || 0,
                nodeTotal.data('byuvf') || 0,
                nodeTotal.data('mytel') || 0
            ]);
        }

        doc.content[1].table.body = newBody;

        // 🔥 FONT LEBIH KECIL
        doc.defaultStyle.fontSize = 6;

        // 🔥 MARGIN DIKECILKAN
        doc.pageMargins = [10, 10, 10, 10];

        // 🔥 AUTO WIDTH
        doc.content[1].table.widths = Array(newHeader.length).fill('*');

        // CENTER TITLE
        doc.styles.title = {
            alignment: 'center',
            fontSize: 12,
            bold: true
        };

        // WRAP TEXT
        doc.styles.tableBodyEven = { fontSize: 6 };
        doc.styles.tableBodyOdd  = { fontSize: 6 };
    }
}

    ],
    language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        paginate: { next: "›", previous: "‹" }
    }
});


  

});
</script>

<script>
function openDetailModal1(data) {
    document.getElementById('detailPerdana').innerText = data.perdana;
    document.getElementById('detailByu').innerText = data.byu;
    document.getElementById('detailLite').innerText = data.lite;
    document.getElementById('detailOrbit').innerText = data.orbit;
    // document.getElementById('detailCvmByu').innerText = data.cvm_byu;
    // document.getElementById('detailSuper').innerText = data.super_seru;
    // document.getElementById('detailDigital').innerText = data.digital;
    // document.getElementById('detailRoaming').innerText = data.roaming;
    // document.getElementById('detailVfhp').innerText = data.vf_hp;
    // document.getElementById('detailVflitebyu').innerText = data.vf_lite_byu;
    // document.getElementById('detailLitevf').innerText = data.lite_vf;
    // document.getElementById('detailByuvf').innerText = data.byu_vf;
    // document.getElementById('detailMytelkomsel').innerText = data.mytelkomsel;

    const modal = document.getElementById('detailModal1');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
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
@endpush
