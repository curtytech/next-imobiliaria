@php
    $component = $attributes->has('href') ? 'a' : 'button';
@endphp

@if ($component === 'a')
    <a
        {{ $attributes->twMerge('py-2 px-4 font-semibold rounded-lg border transition border-primary text-primary hover:bg-primary hover:text-white') }}
    >
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->twMerge('py-2 px-4 font-semibold rounded-lg border transition border-primary text-primary hover:bg-primary hover:text-white') }}
    >
        {{ $slot }}
    </button>
@endif