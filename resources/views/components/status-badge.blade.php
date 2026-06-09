@props(['status'])

@php
    $statusValue = strtolower((string) $status);
    $config = match ($statusValue) {
        'pending' => ['dot' => 'bg-yellow-500', 'bg' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20 dark:bg-yellow-400/10 dark:text-yellow-400 dark:ring-yellow-400/20'],
        'verified' => ['dot' => 'bg-blue-500', 'bg' => 'bg-blue-50 text-blue-700 ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/20'],
        'assigned' => ['dot' => 'bg-indigo-500', 'bg' => 'bg-indigo-50 text-indigo-700 ring-indigo-700/10 dark:bg-indigo-400/10 dark:text-indigo-400 dark:ring-indigo-400/20'],
        'in_progress' => ['dot' => 'bg-orange-500', 'bg' => 'bg-orange-50 text-orange-700 ring-orange-600/20 dark:bg-orange-400/10 dark:text-orange-400 dark:ring-orange-400/20'],
        'resolved' => ['dot' => 'bg-emerald-500', 'bg' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/20'],
        'reopened' => ['dot' => 'bg-red-500', 'bg' => 'bg-red-50 text-red-700 ring-red-600/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/20'],
        'rejected' => ['dot' => 'bg-zinc-400', 'bg' => 'bg-zinc-50 text-zinc-700 ring-zinc-600/10 dark:bg-zinc-400/10 dark:text-zinc-400 dark:ring-zinc-400/20'],
        'closed' => ['dot' => 'bg-zinc-800 dark:bg-zinc-300', 'bg' => 'bg-zinc-800 text-zinc-100 ring-zinc-900/10 dark:bg-zinc-300/10 dark:text-zinc-300 dark:ring-zinc-300/20'],
        default => ['dot' => 'bg-zinc-400', 'bg' => 'bg-zinc-50 text-zinc-700 ring-zinc-600/10 dark:bg-zinc-400/10 dark:text-zinc-400 dark:ring-zinc-400/20'],
    };
@endphp

<span {{ $attributes->merge(['class' => "badge {$config['bg']}"]) }}>
    <span class="badge-dot {{ $config['dot'] }}"></span>
    {{ ucfirst(str_replace('_', ' ', $statusValue)) }}
</span>
