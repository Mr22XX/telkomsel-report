@extends('layouts.main')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
     <div class="absolute flex gap-1 items-center top-2 left-3">
        <img class=" bg-white rounded-full" src="/icon.png" width="40" height="40" alt="" >
        <h1 class="text-2xl font-bold text-slate-950">TSR</h1>
    </div>

        
        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Reset Password
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Masukkan password baru untuk akun Anda
            </p>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    value="{{ old('email', request()->email) }}"
                    required
                    autofocus
                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                >
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Password Baru
                </label>
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                >
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Konfirmasi Password
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Konfirmasi Password"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                >
                @error('password_confirmation')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg transition"
            >
                Reset Password
            </button>
        </form>
    </div>
</div>
@endsection
