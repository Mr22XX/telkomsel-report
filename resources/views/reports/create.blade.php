@extends('layouts.sales')

@section('title', 'Create Report')
@section('page-title', 'Create Report')

@section('content')

<div class="max-w-6xl mx-auto">
    
    <form action="{{ route('reports.store') }}" method="POST"
    class="bg-white rounded-xl shadow p-6 space-y-6">
    <h1 class="text-2xl p-2 font-bold">Tambah Laporan</h1>
    @csrf

        <!-- INFO UTAMA -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal"
                       class="w-full mt-1 rounded-lg border p-1 border-gray-300 focus:ring-red-500 focus:border-red-500"
                       required>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Tap</label>
                <input type="text" name="tap"
                       class="w-full mt-1 rounded-lg border p-1 border-gray-300 focus:ring-red-500 focus:border-red-500"
                       placeholder="Contoh: Bengkulu">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Nama Sales</label>
                <input type="text" name="nama_sales"
                       value="{{ auth()->user()->name }}"
                       class="w-full mt-1 rounded-lg border p-1 border-gray-300 bg-gray-100"
                       readonly>
            </div>
        </div>

        <!-- FOKUS -->
        <div>
            <label class="text-sm font-medium text-gray-700">Fokus Penjualan</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-2">
                <input type="text" name="fokus_1" placeholder="Fokus 1"
                       class="rounded-lg border p-1 border-gray-300">
                <input type="text" name="fokus_2" placeholder="Fokus 2"
                       class="rounded-lg border p-1 border-gray-300">
                <input type="text" name="fokus_3" placeholder="Fokus 3"
                       class="rounded-lg border p-1 border-gray-300">
            </div>
        </div>

        <!-- PENJUALAN -->
        <div>
            <h3 class="font-semibold text-gray-700 mb-3">
                Data Penjualan
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                @php
                $fields = [
                    'perdana','byu','lite','orbit','cvm_byu','super_seru',
                    'digital','roaming','vf_hp','vf_lite_byu',
                    'lite_vf','byu_vf','my_telkomsel'
                ];
                @endphp

                @foreach ($fields as $field)
                <div>
                    <label class="text-xs text-gray-600 uppercase">
                        {{ str_replace('_', ' ', $field) }}
                    </label>
                    <input type="number" name="{{ $field }}"
                           value="0" min="0"
                           class="w-full mt-1 rounded-lg border p-1 border-gray-300 focus:ring-red-500 focus:border-red-500">
                </div>
                @endforeach

            </div>
        </div>

        <!-- ACTION -->
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('reports.index') }}"
               class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                Batal
            </a>

            <button type="submit"
                    class="px-6 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                Simpan Report
            </button>
        </div>

    </form>

</div>

@endsection
