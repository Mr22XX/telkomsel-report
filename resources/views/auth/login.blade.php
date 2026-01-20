@extends('layouts.main')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 relative">
    <img class="absolute top-2 left-3" src="/icon.png" width="50" height="50" alt="">

    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">

        <h2 class="text-2xl font-bold text-red-600 text-center mb-6">
            Login
        </h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm text-gray-600">Email</label>
                <input type="email" name="email" required placeholder="Example@gmail.com"
                       class="w-full mt-1 border rounded-lg px-4 py-2 focus:ring-red-500 focus:border-red-500">
            </div>

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

            <button
                class="w-full bg-red-600 text-white py-3 rounded-xl font-semibold hover:bg-red-700 transition">
                Login
            </button>
        </form>

        <p class="text-sm text-center mt-6 text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-red-600 font-semibold">
                Register
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
