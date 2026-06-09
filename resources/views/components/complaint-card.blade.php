@props(['complaint'])

<a href="{{ route('student.complaints.show', $complaint) }}" class="group relative flex flex-col justify-between overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 p-6 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700 transition hover:shadow-md hover:ring-zinc-300 dark:hover:ring-zinc-600">
    <div>
        <div class="flex items-center justify-between mb-4">
            <span class="inline-flex items-center rounded-md bg-zinc-100 dark:bg-zinc-700/50 px-2 py-1 text-xs font-medium text-zinc-600 dark:text-zinc-300 ring-1 ring-inset ring-zinc-500/10">
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
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 font-medium">{{ $complaint->category?->name ?? 'Uncategorized' }}</p>
    </div>
    
    <div class="mt-6 flex items-center text-xs text-zinc-500 dark:text-zinc-400 border-t border-zinc-100 dark:border-zinc-700/50 pt-4 gap-1.5">
        <flux:icon.calendar class="size-3.5" />
        Submitted {{ optional($complaint->created_at)->format('M d, Y h:i A') }}
    </div>
</a>
