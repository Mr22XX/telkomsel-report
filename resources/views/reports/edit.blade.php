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
                    $fields = [
                        'perdana' => 'Perdana',
                        'byu' => 'ByU',
                        'lite' => 'Lite',
                        'orbit' => 'Orbit',
                        'cvm_byu' => 'CVM ByU',
                        'super_seru' => 'Super Seru',
                        'digital' => 'Digital',
                        'roaming' => 'Roaming',
                        'my_telkomsel' => 'MyTelkomsel',
                    ];
                @endphp

                @foreach ($fields as $key => $label)
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">
                            {{ $label }}
                        </label>
                        <input type="number"
                               min="0"
                               name="{{ $key }}"
                               value="{{ old($key, $report->$key) }}"
                               class="w-full border p-1 rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
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
