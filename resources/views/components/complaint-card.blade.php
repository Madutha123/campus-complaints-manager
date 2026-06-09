@props(['complaint'])

@php
    $statusColor = match ($complaint->status) {
        'pending' => 'bg-yellow-500',
        'verified' => 'bg-blue-500',
        'assigned' => 'bg-indigo-500',
        'in_progress' => 'bg-orange-500',
        'resolved' => 'bg-emerald-500',
        'reopened' => 'bg-red-500',
        'rejected' => 'bg-zinc-400',
        'closed' => 'bg-zinc-800 dark:bg-zinc-300',
        default => 'bg-zinc-400',
    };
@endphp

<a href="{{ route('student.complaints.show', $complaint) }}" class="group relative flex flex-col justify-between overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700 transition-all duration-200 hover:shadow-md hover:ring-zinc-300 dark:hover:ring-zinc-600 hover:-translate-y-0.5">
    <!-- Status bar -->
    <div class="absolute top-0 left-0 right-0 h-1 {{ $statusColor }}"></div>

    <div class="p-6 pt-7">
        <div class="flex items-center justify-between mb-4">
            <span class="inline-flex items-center rounded-md bg-zinc-100 dark:bg-zinc-700/50 px-2 py-1 text-xs font-mono font-medium text-zinc-600 dark:text-zinc-300 ring-1 ring-inset ring-zinc-500/10">
                {{ $complaint->ticket_no }}
            </span>
            <div class="flex gap-2">
                <x-status-badge :status="$complaint->status" />
                <x-priority-badge :priority="$complaint->priority" />
            </div>
        </div>

        <h3 class="text-base font-semibold text-zinc-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition line-clamp-1">
            {{ $complaint->title }}
        </h3>

        <div class="mt-2 flex items-center gap-2">
            <span class="inline-flex items-center rounded-md bg-indigo-50 dark:bg-indigo-500/10 px-2 py-0.5 text-xs font-medium text-indigo-700 dark:text-indigo-400">
                {{ $complaint->category?->name ?? 'Uncategorized' }}
            </span>
        </div>
    </div>

    <div class="mx-6 pb-4 flex items-center text-xs text-zinc-500 dark:text-zinc-400 border-t border-zinc-100 dark:border-zinc-700/50 pt-3 gap-1.5">
        <flux:icon.calendar class="size-3.5" />
        Submitted {{ optional($complaint->created_at)->format('M d, Y h:i A') }}
    </div>
</a>
