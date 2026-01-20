@extends('layouts.main')

@section('content')
<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2 relative">
    <div class="flex flex-col justify-center px-10 lg:px-20 text-white">
        <img class="absolute top-2 left-3 lg:w-[50px] lg:h-[70px] h-[40px] sm:my-5 sm:mx-5" src="/icon.png"  alt="">
        <h1 class="text-4xl lg:text-5xl font-bold leading-tight mt-3">
            Telkomsel<br>
            Sales Reporting System
        </h1>

        <p class="mt-6 text-lg text-red-100 max-w-md">
            Platform internal untuk mencatat dan memantau laporan
            penjualan sales secara real-time, akurat, dan terpusat.
        </p>
    </div>

    <!-- RIGHT -->
    <div class="flex items-center justify-center bg-white">
        <div class="w-full max-w-md p-10">

            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                Masuk ke Sistem
            </h2>

            <p class="text-sm text-gray-500 mb-8">
                Gunakan akun internal Telkomsel
            </p>

            <div class="space-y-4">
                <a href="{{ route('login') }}"
                   class="block w-full text-center bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="block w-full text-center border border-red-600 text-red-600 py-3 rounded-lg font-semibold hover:bg-red-50 transition">
                    Register
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
