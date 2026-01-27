@extends('layouts.manager')

@section('title','Manajemen Sales')
@section('page-title','Manajemen Sales')

@section('content')

<div class="bg-white rounded-2xl shadow p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold">Daftar Sales</h2>

        <a href="{{ route('manager.users.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Sales
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th class="w-40">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $i => $u)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-2">{{ $users->firstItem() + $i }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td class="flex gap-2 py-2">
                    <a href="{{ route('manager.users.edit',$u->id) }}"
                       class="bg-yellow-400 text-white px-3 py-1 rounded-lg hover:bg-yellow-500">
                        Edit
                    </a>

                    <form action="{{ route('manager.users.destroy',$u->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus sales ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</div>

@endsection
