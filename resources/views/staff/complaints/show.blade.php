@extends('layouts.staff')

@section('staff-content')
<div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 border-b border-zinc-200 dark:border-zinc-700/50 pb-6">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <a href="{{ route('staff.complaints.index') }}" class="btn-ghost -ml-2 text-xs">
                    <flux:icon.arrow-left class="size-3.5" />
                    Back to assigned
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
                Submitted by <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $complaint->submitter?->name ?? '-' }}</span> on {{ optional($complaint->created_at)->format('F j, Y \a\t g:i A') }}
            </p>
        </div>
    </div>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if ($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <div class="grid gap-6 xl:grid-cols-3">
        <!-- Main Content -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Details Grid -->
            <div class="card">
                <div class="card-header">
                    <h2 class="section-heading">Complaint Information</h2>
                </div>
                <div class="card-body">
                    <dl class="grid gap-x-6 gap-y-6 sm:grid-cols-2 text-sm">
                        <div>
                            <dt class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                                <flux:icon.tag class="size-3.5" />
                                Category
                            </dt>
                            <dd class="mt-1.5 font-medium text-zinc-900 dark:text-white">{{ $complaint->category?->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                                <flux:icon.building-office-2 class="size-3.5" />
                                Department
                            </dt>
                            <dd class="mt-1.5 font-medium text-zinc-900 dark:text-white">{{ $complaint->department?->name ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-zinc-500 dark:text-zinc-400 flex items-center gap-1.5">
                                <flux:icon.map-pin class="size-3.5" />
                                Location
                            </dt>
                            <dd class="mt-1.5 font-medium text-zinc-900 dark:text-white">{{ $complaint->location ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2 border-t border-zinc-100 dark:border-zinc-700/50 pt-6">
                            <dt class="text-zinc-500 dark:text-zinc-400 font-medium mb-3">Description</dt>
                            <dd class="prose dark:prose-invert max-w-none text-sm text-zinc-700 dark:text-zinc-300 whitespace-pre-line leading-relaxed bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-5 ring-1 ring-zinc-200 dark:ring-zinc-700/50">{{ $complaint->description }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="card">
                <div class="card-header">
                    <h2 class="section-heading">Activity Timeline</h2>
                </div>
                <div class="card-body">
                    <div class="relative">
                        <div class="absolute left-[11px] top-2 bottom-2 w-0.5 bg-zinc-200 dark:bg-zinc-700 rounded-full"></div>

                        <div class="space-y-8">
                            @forelse ($complaint->activityLogs as $log)
                                @php
                                    $actionColors = match (true) {
                                        str_contains(strtolower($log->action ?? ''), 'resolve') || str_contains(strtolower($log->action ?? ''), 'close') => 'border-emerald-500 bg-emerald-100 dark:bg-emerald-500/20',
                                        str_contains(strtolower($log->action ?? ''), 'reject') => 'border-red-500 bg-red-100 dark:bg-red-500/20',
                                        str_contains(strtolower($log->action ?? ''), 'assign') => 'border-indigo-500 bg-indigo-100 dark:bg-indigo-500/20',
                                        str_contains(strtolower($log->action ?? ''), 'reopen') => 'border-orange-500 bg-orange-100 dark:bg-orange-500/20',
                                        default => 'border-zinc-400 bg-zinc-100 dark:bg-zinc-500/20',
                                    };
                                @endphp
                                <div class="relative pl-10 group">
                                    <div class="absolute left-0 top-1.5 w-[23px] h-[23px] rounded-full border-4 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                                        <div class="w-2 h-2 rounded-full {{ explode(' ', $actionColors)[1] ?? 'bg-zinc-400' }}"></div>
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
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 py-1">No activity logs.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Update Status -->
        <div class="space-y-6">
            <div class="card sticky top-6">
                <div class="card-header">
                    <h2 class="section-heading">Update Status</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('staff.complaints.update-status', $complaint) }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="status" class="form-label">New Status</label>
                            <select id="status" name="status" class="form-select" required>
                                @foreach ($statusOptions as $statusOption)
                                    <option value="{{ $statusOption }}" @selected(old('status', $complaint->status) === $statusOption)>{{ ucfirst(str_replace('_', ' ', $statusOption)) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="note" class="form-label">Resolution Notes</label>
                            <textarea id="note" name="note" rows="4" placeholder="Detail the steps taken..." class="form-input min-h-[100px]">{{ old('note') }}</textarea>
                        </div>

                        <button type="submit" class="btn-primary w-full">
                            <flux:icon.arrow-up class="size-4" />
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
