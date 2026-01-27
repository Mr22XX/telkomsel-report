@extends('layouts.manager')

@section('title','Tambah Sales')
@section('page-title','Tambah Sales')

@section('content')

<div class="bg-white rounded-2xl shadow p-6 max-w-xl mx-auto">

    <h2 class="text-lg font-semibold mb-6">Tambah Akun Sales</h2>

    <form action="{{ route('manager.users.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="text-sm text-gray-600">Nama Sales</label>
            <input type="text" name="name" class="w-full border rounded-lg p-2"
                   placeholder="Masukkan nama sales" required>
        </div>

        <div>
            <label class="text-sm text-gray-600">Email</label>
            <input type="email" name="email" class="w-full border rounded-lg p-2"
                   placeholder="Masukkan email" required>
        </div>

        <div>
            <label class="text-sm text-gray-600">Password</label>
            <input type="password" name="password" class="w-full border rounded-lg p-2"
                   placeholder="Minimal 6 karakter" required>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('manager.users') }}"
               class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
                Batal
            </a>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>

</div>

@endsection
