@props(['priority'])

@php
    $value = strtolower((string) $priority);
    $config = match ($value) {
        'low' => ['icon' => 'arrow-down', 'bg' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/20'],
        'medium' => ['icon' => 'minus', 'bg' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20 dark:bg-yellow-400/10 dark:text-yellow-400 dark:ring-yellow-400/20'],
        'high' => ['icon' => 'arrow-up', 'bg' => 'bg-orange-50 text-orange-700 ring-orange-600/20 dark:bg-orange-400/10 dark:text-orange-400 dark:ring-orange-400/20'],
        'critical' => ['icon' => 'chevron-double-up', 'bg' => 'bg-red-50 text-red-700 ring-red-600/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/20'],
        default => ['icon' => 'minus', 'bg' => 'bg-zinc-50 text-zinc-700 ring-zinc-600/10 dark:bg-zinc-400/10 dark:text-zinc-400 dark:ring-zinc-400/20'],
    };
@endphp

<span {{ $attributes->merge(['class' => "badge {$config['bg']}"]) }}>
    <flux:icon.{{ $config['icon'] }} class="size-3" />
    {{ ucfirst($value) }}
</span>
