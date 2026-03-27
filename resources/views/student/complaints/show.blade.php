@extends('layouts.student')

@section('student-content')
<div class="space-y-6">
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $complaint->ticket_no }}</p>
            <h1 class="mt-1 text-2xl font-bold text-gray-900">{{ $complaint->title }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <x-status-badge :status="$complaint->status" />
            <x-priority-badge :priority="$complaint->priority" />
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-xl border border-gray-200 bg-white p-6">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Description</h2>
            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-700">{{ $complaint->description }}</p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Complaint Details</h2>
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Category</dt><dd class="font-medium text-gray-800">{{ $complaint->category?->name ?? '-' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Department</dt><dd class="font-medium text-gray-800">{{ $complaint->department?->name ?? '-' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Assigned To</dt><dd class="font-medium text-gray-800">{{ $complaint->assignedTo?->name ?? 'Not assigned' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Location</dt><dd class="font-medium text-gray-800">{{ $complaint->location ?? '-' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Submitted</dt><dd class="font-medium text-gray-800">{{ optional($complaint->created_at)->format('M d, Y h:i A') }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Due Date</dt><dd class="font-medium text-gray-800">{{ optional($complaint->due_date)->format('M d, Y h:i A') ?? '-' }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Resolved At</dt><dd class="font-medium text-gray-800">{{ optional($complaint->resolved_at)->format('M d, Y h:i A') ?? '-' }}</dd></div>
            </dl>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Activity Log</h2>
        <div class="mt-4 space-y-4">
            @forelse ($complaint->activityLogs as $log)
                <div class="relative pl-6">
                    <span class="absolute left-0 top-1.5 h-2.5 w-2.5 rounded-full bg-gray-400"></span>
                    <p class="text-sm font-semibold text-gray-800">{{ $log->action }}</p>
                    <p class="text-xs text-gray-500">{{ optional($log->created_at)->format('M d, Y h:i A') }} by {{ $log->user?->name ?? 'System' }}</p>
                    @if ($log->note)
                        <p class="mt-1 text-sm text-gray-600">{{ $log->note }}</p>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">No activity recorded yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
