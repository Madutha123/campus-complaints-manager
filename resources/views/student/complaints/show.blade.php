@extends('layouts.student')

@section('student-content')
<div class="space-y-6 max-w-5xl">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 border-b border-zinc-200 dark:border-zinc-700/50 pb-6">
        <div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center rounded-md bg-zinc-100 dark:bg-zinc-700/50 px-2.5 py-1 sm:text-xs font-semibold text-zinc-700 dark:text-zinc-300 ring-1 ring-inset ring-zinc-500/10">
                    {{ $complaint->ticket_no }}
                </span>
                <x-status-badge :status="$complaint->status" />
                <x-priority-badge :priority="$complaint->priority" />
            </div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $complaint->title }}</h1>
            <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400">
                Submitted on {{ optional($complaint->created_at)->format('F j, Y \a\t g:i A') }}
            </p>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Main Description -->
        <div class="lg:col-span-2 overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700">
            <div class="px-6 py-5 border-b border-zinc-100 dark:border-zinc-700/50">
                <h2 class="text-base font-semibold leading-7 text-zinc-900 dark:text-white">Description</h2>
            </div>
            <div class="px-6 py-6">
                <div class="prose dark:prose-invert max-w-none text-sm leading-6 text-zinc-700 dark:text-zinc-300 whitespace-pre-line">
                    {{ $complaint->description }}
                </div>
            </div>
        </div>

        <!-- Meta Sidebar -->
        <div class="overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700">
            <div class="px-6 py-5 border-b border-zinc-100 dark:border-zinc-700/50">
                <h2 class="text-base font-semibold leading-7 text-zinc-900 dark:text-white">Details</h2>
            </div>
            <div class="px-6 py-6">
                <dl class="space-y-4 text-sm">
                    <div class="flex justify-between items-center gap-3">
                        <dt class="text-zinc-500 dark:text-zinc-400">Category</dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ $complaint->category?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center gap-3">
                        <dt class="text-zinc-500 dark:text-zinc-400">Department</dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ $complaint->department?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center gap-3 border-t border-zinc-100 dark:border-zinc-700/50 pt-4">
                        <dt class="text-zinc-500 dark:text-zinc-400">Location</dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ $complaint->location ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center gap-3 border-t border-zinc-100 dark:border-zinc-700/50 pt-4">
                        <dt class="text-zinc-500 dark:text-zinc-400">Assigned To</dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ $complaint->assignedTo?->name ?? 'Unassigned' }}</dd>
                    </div>
                    <div class="flex justify-between items-center gap-3 border-t border-zinc-100 dark:border-zinc-700/50 pt-4">
                        <dt class="text-zinc-500 dark:text-zinc-400">Due Date</dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ optional($complaint->due_date)->format('M d, Y h:i A') ?? '-' }}</dd>
                    </div>
                    @if ($complaint->resolved_at)
                        <div class="flex justify-between items-center gap-3 border-t border-zinc-100 dark:border-zinc-700/50 pt-4">
                            <dt class="text-zinc-500 dark:text-zinc-400">Resolved At</dt>
                            <dd class="font-medium text-emerald-600 dark:text-emerald-400">{{ optional($complaint->resolved_at)->format('M d, Y h:i A') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <!-- Timeline / Activity -->
    <div class="overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700 mt-8">
        <div class="px-6 py-5 border-b border-zinc-100 dark:border-zinc-700/50">
            <h2 class="text-base font-semibold leading-7 text-zinc-900 dark:text-white">Activity Timeline</h2>
        </div>
        <div class="px-6 py-6 border-l-2 border-zinc-100 dark:border-zinc-700 ml-8 mt-2 space-y-8">
            @forelse ($complaint->activityLogs as $log)
                <div class="relative pl-6 -ml-[2px] transition hover:bg-zinc-50 dark:hover:bg-zinc-800 py-2 rounded-xl">
                    <span class="absolute -left-[31px] top-1 h-[22px] w-[22px] bg-white dark:bg-zinc-800 rounded-full border-4 border-zinc-200 dark:border-zinc-600 shadow-sm"></span>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $log->action }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                        {{ optional($log->created_at)->format('F j, Y g:i A') }} &middot; by <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $log->user?->name ?? 'System' }}</span>
                    </p>
                    @if ($log->note)
                        <div class="mt-3 text-sm text-zinc-600 dark:text-zinc-400 bg-zinc-50 dark:bg-zinc-900/50 rounded-lg p-3 ring-1 ring-zinc-200 dark:ring-zinc-700/50">
                            {{ $log->note }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="pl-6 pb-2">
                    <span class="absolute -left-[7px] top-1.5 h-3.5 w-3.5 rounded-full bg-zinc-200 dark:bg-zinc-700 ring-[4px] ring-white dark:ring-zinc-800"></span>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">No activity recorded yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
