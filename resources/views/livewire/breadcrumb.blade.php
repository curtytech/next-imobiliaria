<?php

use function Livewire\Volt\{state, computed};

state([
    'items' => [],
]);

$formatItems = computed(function () {
    $formattedItems = [];
    
    foreach ($this->items as $item) {
        $formattedItems[] = [
            'label' => $item['label'] ?? '',
            'url' => $item['url'] ?? null,
            'active' => $item['active'] ?? false,
        ];
    }
    
    return $formattedItems;
});

?>

<nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm text-gray-500">
        @foreach ($this->formatItems as $index => $item)
            <li class="{{ $item['active'] ? 'text-gray-900' : '' }}">
                @if ($item['url'] && !$item['active'])
                    <a href="{{ $item['url'] }}" class="hover:text-primary">
                        {{ $item['label'] }}
                    </a>
                @else
                    {{ $item['label'] }}
                @endif
            </li>
            
            @if (!$loop->last)
                <li>
                    <x-lucide-chevron-right class="w-4 h-4" />
                </li>
            @endif
        @endforeach
    </ol>
</nav>