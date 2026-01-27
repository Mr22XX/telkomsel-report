@extends('layouts.manager')

@section('title','Edit Sales')
@section('page-title','Edit Sales')

@section('content')

<div class="bg-white rounded-2xl shadow p-6 max-w-xl mx-auto">

    <h2 class="text-lg font-semibold mb-6">Edit Akun Sales</h2>

    <form action="{{ route('manager.users.update',$user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="text-sm text-gray-600">Nama Sales</label>
            <input type="text" name="name" value="{{ $user->name }}"
                   class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="text-sm text-gray-600">Email</label>
            <input type="email" name="email" value="{{ $user->email }}"
                   class="w-full border rounded-lg p-2" required>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('manager.users') }}"
               class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
                Batal
            </a>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>

</div>

@endsection
