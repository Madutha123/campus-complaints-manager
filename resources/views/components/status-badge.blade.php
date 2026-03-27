@props(['status'])

@php
    $statusValue = strtolower((string) $status);
    $classes = match ($statusValue) {
        'pending' => 'bg-yellow-100 text-yellow-800',
        'verified' => 'bg-blue-100 text-blue-800',
        'assigned' => 'bg-indigo-100 text-indigo-800',
        'in_progress' => 'bg-orange-100 text-orange-800',
        'resolved' => 'bg-green-100 text-green-800',
        'reopened' => 'bg-red-100 text-red-800',
        'rejected' => 'bg-gray-100 text-gray-800',
        'closed' => 'bg-gray-800 text-gray-100',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {$classes}"]) }}>
    {{ ucfirst(str_replace('_', ' ', $statusValue)) }}
</span>
