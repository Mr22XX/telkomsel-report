@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            Telkomsel Report
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} Telkomsel Report. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
