@extends('layouts.main')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 relative">
    <img class="absolute top-2 left-3" src="/icon.png" width="50" height="50" alt="">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        <!-- HEADER -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Registrasi Akun
            </h1>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- NAME -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Lengkap
                </label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap"
                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                    required>
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                    class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                    required>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASSWORD -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Password
            </label>

            <div class="relative">
                <input id="password" type="password" name="password" placeholder="Password"
                    class="w-full rounded-lg border-gray-300 pr-12 focus:border-red-500 focus:ring-red-500"
                    required>

                <button type="button"
                    onclick="togglePassword('password', this)"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-red-600">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

            <!-- CONFIRM PASSWORD -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Konfirmasi Password
            </label>

            <div class="relative">
                <input id="password_confirmation" type="password" placeholder="Konfirmasi Password"
                    name="password_confirmation"
                    class="w-full rounded-lg border-gray-300 pr-12 focus:border-red-500 focus:ring-red-500"
                    required>

                <button type="button"
                    onclick="togglePassword('password_confirmation', this)"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-red-600">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
        </div>


            <!-- BUTTON -->
            <button type="submit"
                class="w-full mt-4 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg transition">
                Daftar
            </button>
        </form>

        <!-- FOOTER -->
        <p class="text-sm text-center text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-red-600 font-semibold hover:underline">
                Login
            </a>
        </p>

    </div>

</div>
@endsection

<script>
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

