@extends('layouts.main')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4 relative flex-col">
    <img class="absolute top-2 left-3" src="/icon.png" width="50" height="50" alt="">

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus  />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
        <div class="mb-4 text-sm text-white w-[30%] text-center">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
</div>


@endsection