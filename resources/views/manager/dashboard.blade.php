@extends('layouts.main')

@section('content')
<div class="min-h-screen p-6">

    <!-- HEADER -->
    <div class="bg-white rounded-xl shadow p-6 mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-red-600">
                Dashboard Manager
            </h1>
            <p class="text-sm text-gray-600">
                Selamat datang, {{ Auth::user()->name }}
            </p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="mt-4 md:mt-0 bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700">
                Logout
            </button>
        </form>
    </div>

    <!-- SUMMARY -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Total Report</p>
            <h2 class="text-3xl font-bold text-red-600">12</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
            <h2 class="text-3xl font-bold text-red-600">Rp 3.500.000</h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Sales Aktif</p>
            <h2 class="text-3xl font-bold text-red-600">45</h2>
        </div>
    </div>

</div>
@endsection
