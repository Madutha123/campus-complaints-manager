@props([
    'type' => 'success',
    'message' => null,
])

@php
    $config = match ($type) {
        'error' => ['icon' => 'x-circle', 'classes' => 'border-red-200 dark:border-red-500/20 bg-red-50 dark:bg-red-500/10 text-red-800 dark:text-red-200', 'iconClass' => 'text-red-500 dark:text-red-400'],
        'warning' => ['icon' => 'exclamation-triangle', 'classes' => 'border-yellow-200 dark:border-yellow-500/20 bg-yellow-50 dark:bg-yellow-500/10 text-yellow-800 dark:text-yellow-200', 'iconClass' => 'text-yellow-500 dark:text-yellow-400'],
        default => ['icon' => 'check-circle', 'classes' => 'border-emerald-200 dark:border-emerald-500/20 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-200', 'iconClass' => 'text-emerald-500 dark:text-emerald-400'],
    };
@endphp

@if ($message)
    <div x-data="{ open: true }" x-show="open" x-transition.duration.300ms {{ $attributes->merge(['class' => "rounded-xl border p-4 {$config['classes']}"]) }}>
        <div class="flex items-start justify-between gap-3">
            <div class="flex items-start gap-3">
                <flux:icon.{{ $config['icon'] }} class="mt-0.5 size-5 shrink-0 {{ $config['iconClass'] }}" />
                <p class="text-sm font-medium">{{ $message }}</p>
            </div>
            <button type="button" class="shrink-0 rounded-lg p-1 opacity-60 transition hover:opacity-100 hover:bg-black/5 dark:hover:bg-white/5" @click="open = false">
                <flux:icon.x-mark class="size-4" />
            </button>
        </div>
    </div>
@endif
