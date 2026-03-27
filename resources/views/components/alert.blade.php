@props([
    'type' => 'success',
    'message' => null,
])

@php
    $classes = match ($type) {
        'error' => 'border-red-200 bg-red-50 text-red-800',
        'warning' => 'border-yellow-200 bg-yellow-50 text-yellow-800',
        default => 'border-green-200 bg-green-50 text-green-800',
    };
@endphp

@if ($message)
    <div x-data="{ open: true }" x-show="open" x-transition {{ $attributes->merge(['class' => "rounded-lg border p-4 {$classes}"]) }}>
        <div class="flex items-start justify-between gap-4">
            <p class="text-sm font-medium">{{ $message }}</p>
            <button type="button" class="text-sm font-semibold opacity-75 transition hover:opacity-100" @click="open = false">
                Dismiss
            </button>
        </div>
    </div>
@endif
