@extends('layouts.student')

@section('student-content')
<div class="space-y-6 max-w-5xl">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 border-b border-zinc-200 dark:border-zinc-700/50 pb-6">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <a href="{{ route('student.complaints.index') }}" class="btn-ghost -ml-2 text-xs">
                    <flux:icon.arrow-left class="size-3.5" />
                    Back to my complaints
                </a>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center rounded-lg bg-zinc-100 dark:bg-zinc-700/50 px-3 py-1.5 text-xs font-mono font-semibold text-zinc-700 dark:text-zinc-300 ring-1 ring-inset ring-zinc-500/10">
                    <flux:icon.hashtag class="size-3 mr-1.5 text-zinc-400" />
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
        <div class="lg:col-span-2 card">
            <div class="card-header">
                <h2 class="section-heading">Description</h2>
            </div>
            <div class="card-body">
                <div class="prose dark:prose-invert max-w-none text-sm leading-6 text-zinc-700 dark:text-zinc-300 whitespace-pre-line">
                    {{ $complaint->description }}
                </div>
            </div>
        </div>

        <!-- Meta Sidebar -->
        <div class="card">
            <div class="card-header">
                <h2 class="section-heading">Details</h2>
            </div>
            <div class="card-body">
                <dl class="space-y-5 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                            <flux:icon.tag class="size-3.5" />
                            Category
                        </dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ $complaint->category?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                            <flux:icon.building-office-2 class="size-3.5" />
                            Department
                        </dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ $complaint->department?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-zinc-100 dark:border-zinc-700/50">
                        <dt class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                            <flux:icon.map-pin class="size-3.5" />
                            Location
                        </dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ $complaint->location ?? '-' }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-zinc-100 dark:border-zinc-700/50">
                        <dt class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                            <flux:icon.user class="size-3.5" />
                            Assigned To
                        </dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ $complaint->assignedTo?->name ?? 'Unassigned' }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3 pt-3 border-t border-zinc-100 dark:border-zinc-700/50">
                        <dt class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                            <flux:icon.clock class="size-3.5" />
                            Due Date
                        </dt>
                        <dd class="font-medium text-zinc-900 dark:text-white">{{ optional($complaint->due_date)->format('M d, Y h:i A') ?? '-' }}</dd>
                    </div>
                    @if ($complaint->resolved_at)
                        <div class="flex items-center justify-between gap-3 pt-3 border-t border-zinc-100 dark:border-zinc-700/50">
                            <dt class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                                <flux:icon.check-circle class="size-3.5" />
                                Resolved At
                            </dt>
                            <dd class="font-medium text-emerald-600 dark:text-emerald-400">{{ optional($complaint->resolved_at)->format('M d, Y h:i A') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <!-- Timeline / Activity -->
    <div class="card mt-8">
        <div class="card-header">
            <h2 class="section-heading">Activity Timeline</h2>
        </div>
        <div class="card-body">
            <div class="relative">
                <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-zinc-200 dark:bg-zinc-700 rounded-full"></div>

                <div class="space-y-8">
                    @forelse ($complaint->activityLogs as $log)
                        <div class="relative pl-10 group">
                            <div class="absolute left-0 top-1.5 w-[23px] h-[23px] rounded-full border-4 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                <div class="w-2 h-2 rounded-full bg-zinc-400 dark:bg-zinc-500"></div>
                            </div>
                            <div class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50 -mx-3 px-3 py-2 rounded-xl">
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $log->action }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                    {{ optional($log->created_at)->format('F j, Y g:i A') }} &middot; by <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $log->user?->name ?? 'System' }}</span>
                                </p>
                                @if ($log->note)
                                    <div class="mt-3 text-sm text-zinc-600 dark:text-zinc-400 bg-zinc-50 dark:bg-zinc-900/50 rounded-lg p-4 ring-1 ring-zinc-200 dark:ring-zinc-700/50 border-l-2 border-indigo-400/50">
                                        {{ $log->note }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="relative pl-10">
                            <div class="absolute left-0 top-1.5 w-[23px] h-[23px] rounded-full border-4 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800"></div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 py-1">No activity recorded yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
