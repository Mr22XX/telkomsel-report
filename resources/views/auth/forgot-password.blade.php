@extends('layouts.main')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4 relative flex-col">
      <div class="absolute flex gap-1 items-center top-2 left-3">
        <img class=" bg-white rounded-full" src="/icon.png" width="40" height="40" alt="" >
        <h1 class="text-2xl font-bold text-white">TSR</h1>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        <!-- Email Address -->
        <div>
            <h1 class="text-white mb-16 text-center text-xl font-semibold">Reset Password</h1>
            <x-input-label class="text-white" for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full border border-black" type="email" placeholder="Masukkan email disini" name="email" :value="old('email')" required autofocus  />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
            <div class="flex items-center flex-col justify-end mt-4">
                <div class="mb-4 text-sm text-white w-full text-center">
                    {{ __('Masukkan Email terdaftar anda agar dikirimkan link reset password.') }}
                </div>
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
</div>


@endsection