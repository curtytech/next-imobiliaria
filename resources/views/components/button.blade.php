@php
    $component = $attributes->has('href') ? 'a' : 'button';
@endphp

@if ($component === 'a')
    <a
        {{ $attributes->merge(['component' => $component]) }}
        class="flex-1 py-2 font-semibold rounded-lg border transition border-primary text-primary hover:bg-primary hover:text-white">
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge(['component' => $component]) }}
        class="flex-1 py-2 font-semibold rounded-lg border transition border-primary text-primary hover:bg-primary hover:text-white">
        {{ $slot }}
    </button>
@endif
