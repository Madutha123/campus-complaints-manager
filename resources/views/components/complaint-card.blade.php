@props(['complaint'])

<a href="{{ route('student.complaints.show', $complaint) }}" class="block rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-gray-300 hover:shadow-md">
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $complaint->ticket_no }}</p>
            <h3 class="mt-1 text-lg font-semibold text-gray-900">{{ $complaint->title }}</h3>
            <p class="mt-1 text-sm text-gray-600">{{ $complaint->category?->name ?? 'Uncategorized' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-status-badge :status="$complaint->status" />
            <x-priority-badge :priority="$complaint->priority" />
        </div>
    </div>

    <div class="mt-4 text-sm text-gray-500">
        Submitted {{ optional($complaint->created_at)->format('M d, Y h:i A') }}
    </div>
</a>
