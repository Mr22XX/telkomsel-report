@extends('layouts.sales')

@section('title', 'Edit Report')
@section('page-title', 'Edit Report Penjualan')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl p-2 font-bold mb-4">Edit Laporan</h1>

    <form action="{{ route('reports.update', $report->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- TANGGAL -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date"
                   name="tanggal"
                   value="{{ old('tanggal', $report->tanggal) }}"
                   required
                   class="w-full mt-1 border p-1 rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
        </div>

        <!-- TAP -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">TAP</label>
            <input type="text"
                   name="tap"
                   value="{{ old('tap', $report->tap) }}"
                   required
                   class="w-full mt-1 rounded-lg border p-1 border-gray-300 focus:ring-red-500 focus:border-red-500">
        </div>

        <!-- FOKUS SELLING -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Fokus Selling (Opsional)
            </label>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <input type="text"
                       name="fokus_1"
                       value="{{ old('fokus_1', $report->fokus_1) }}"
                       placeholder="Fokus 1"
                       class="rounded-lg border p-1 border-gray-300 focus:ring-red-500 focus:border-red-500">

                <input type="text"
                       name="fokus_2"
                       value="{{ old('fokus_2', $report->fokus_2) }}"
                       placeholder="Fokus 2"
                       class="rounded-lg border p-1 border-gray-300 focus:ring-red-500 focus:border-red-500">

                <input type="text"
                       name="fokus_3"
                       value="{{ old('fokus_3', $report->fokus_3) }}"
                       placeholder="Fokus 3"
                       class="rounded-lg border p-1 border-gray-300 focus:ring-red-500 focus:border-red-500">
            </div>
        </div>

        <!-- PENJUALAN -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">
                Data Penjualan
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
               @php
                $qtyFields = ['perdana','byu','lite'];

                $revenueFields = [
                    'cvm_byu' => 'CVM ByU',
                    'super_seru' => 'Super Seru',
                    'digital' => 'Digital',
                    'roaming' => 'Roaming',
                    'vf_hp' => 'VF HP',
                    'vf_lite_byu' => 'VF Lite ByU',
                    'lite_vf' => 'Lite VF',
                    'byu_vf' => 'ByU VF',
                    'my_telkomsel' => 'MyTelkomsel',
                ];
                @endphp


                @foreach($qtyFields as $f)
                <div>
                    <label for="" class="block text-xs text-gray-600 mb-1">{{$f}}</label>
                    <input type="number" name="{{ $f }}"
                    value="{{ old($f,$report->$f) }}" class="border p-1 rounded-lg">
                </div>
                @endforeach

                <!-- ORBIT ACCORDION -->
                <div class="col-span-2 md:col-span-4">
                    <details class="border rounded-lg">
                        <summary class="cursor-pointer p-2 font-semibold text-sm bg-gray-100 rounded-lg">
                            Data Orbit
                        </summary>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-3">

                            <div>
                                <label class="text-xs">SP Telkomsel Lite</label>
                                <input type="number" name="sp_telkom"
                                    value="{{ old('sp_telkom', $report->sp_telkom) }}"
                                    min="0" class="border p-1 rounded-lg w-full">
                            </div>

                            <div>
                                <label class="text-xs">Orbit N1</label>
                                <input type="number" name="orbit_n1"
                                    value="{{ old('orbit_n1', $report->orbit_n1) }}"
                                    min="0" class="border p-1 rounded-lg w-full">
                            </div>

                            <div>
                                <label class="text-xs">Orbit Star N2</label>
                                <input type="number" name="orbit_n2"
                                    value="{{ old('orbit_n2', $report->orbit_n2) }}"
                                    min="0" class="border p-1 rounded-lg w-full">
                            </div>

                            <div>
                                <label class="text-xs">Orbit Star N2 (New-01)</label>
                                <input type="number" name="orbit_n2_new"
                                    value="{{ old('orbit_n2_new', $report->orbit_n2_new) }}"
                                    min="0" class="border p-1 rounded-lg w-full">
                            </div>

                            <div>
                                <label class="text-xs">Orbit Star H2</label>
                                <input type="number" name="orbit_h2"
                                    value="{{ old('orbit_h2', $report->orbit_h2) }}"
                                    min="0" class="border p-1 rounded-lg w-full">
                            </div>

                            <div>
                                <label class="text-xs">Orbit Star H2 (NP-01)</label>
                                <input type="number" name="orbit_h2_np01"
                                    value="{{ old('orbit_h2_np01', $report->orbit_h2_np01) }}"
                                    min="0" class="border p-1 rounded-lg w-full">
                            </div>

                            <div>
                                <label class="text-xs">Orbit Star H3</label>
                                <input type="number" name="orbit_h3"
                                    value="{{ old('orbit_h3', $report->orbit_h3) }}"
                                    min="0" class="border p-1 rounded-lg w-full">
                            </div>

                        </div>
                    </details>
                </div>


                @foreach($revenueFields as $key=>$label)
                <div>
                    <label for="" class="block text-xs text-gray-600 mb-1">{{$label}}</label>
                    <input type="text"
                    name="{{ $key }}"
                    value="Rp {{ number_format(old($key,$report->$key),0,',','.') }}"
                    class="rupiah p-1 border rounded-lg">
                </div>
                @endforeach


            </div>
        </div>

        <!-- ACTION -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('reports.index') }}"
               class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                Batal
            </a>

            <button type="submit"
                    class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Update
            </button>
        </div>

    </form>

</div>

@endsection


@push('scripts')
<script>
document.querySelectorAll('.rupiah').forEach(function(input) {
    input.addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value);
    });
});

function formatRupiah(angka) {
    let number_string = angka.replace(/[^,\d]/g, '').toString();
    let split = number_string.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return 'Rp ' + rupiah;
}
</script>
@endpush
