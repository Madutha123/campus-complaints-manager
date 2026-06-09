@extends('layouts.admin')

@section('admin-content')
<div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 border-b border-zinc-200 dark:border-zinc-700/50 pb-6">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.complaints.index') }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 flex items-center gap-1 mb-2">
                    <flux:icon.arrow-left class="size-3" /> Back to complaints
                </a>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center rounded-md bg-zinc-100 dark:bg-zinc-700/50 px-2.5 py-1 sm:text-xs font-semibold text-zinc-700 dark:text-zinc-300 ring-1 ring-inset ring-zinc-500/10">
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
            <div class="overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700">
                <div class="px-6 py-5 border-b border-zinc-100 dark:border-zinc-700/50">
                    <h2 class="text-base font-semibold leading-7 text-zinc-900 dark:text-white">Complaint Information</h2>
                </div>
                <div class="px-6 py-6">
                    <dl class="grid gap-x-4 gap-y-6 sm:grid-cols-2 text-sm">
                        <div class="sm:col-span-1">
                            <dt class="text-zinc-500 dark:text-zinc-400">Category</dt>
                            <dd class="mt-1 font-medium text-zinc-900 dark:text-white">{{ $complaint->category?->name ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-zinc-500 dark:text-zinc-400">Department</dt>
                            <dd class="mt-1 font-medium text-zinc-900 dark:text-white">{{ $complaint->department?->name ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-zinc-500 dark:text-zinc-400">Location</dt>
                            <dd class="mt-1 font-medium text-zinc-900 dark:text-white">{{ $complaint->location ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-zinc-500 dark:text-zinc-400">Due Date</dt>
                            <dd class="mt-1 font-medium text-zinc-900 dark:text-white">{{ optional($complaint->due_date)->format('M d, Y h:i A') ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2 border-t border-zinc-100 dark:border-zinc-700/50 pt-6">
                            <dt class="text-zinc-500 dark:text-zinc-400 font-medium">Description</dt>
                            <dd class="mt-3 prose dark:prose-invert max-w-none text-sm text-zinc-700 dark:text-zinc-300 whitespace-pre-line leading-relaxed">{{ $complaint->description }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700">
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
                            @if ($log->old_status || $log->new_status)
                                <div class="mt-2 flex items-center gap-2 text-xs font-medium text-zinc-600 dark:text-zinc-400">
                                    <span class="px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-700">{{ $log->old_status ?? '-' }}</span>
                                    <flux:icon.arrow-right class="size-3" />
                                    <span class="px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-700">{{ $log->new_status ?? '-' }}</span>
                                </div>
                            @endif
                            @if ($log->note)
                                <div class="mt-3 text-sm text-zinc-600 dark:text-zinc-400 bg-zinc-50 dark:bg-zinc-900/50 rounded-lg p-3 ring-1 ring-zinc-200 dark:ring-zinc-700/50">
                                    {{ $log->note }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="pl-6 pb-2">
                            <span class="absolute -left-[7px] top-1.5 h-3.5 w-3.5 rounded-full bg-zinc-200 dark:bg-zinc-700 ring-[4px] ring-white dark:ring-zinc-800"></span>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No activity logs.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div id="assignment-panel" class="space-y-6">
            <!-- Assignment Form -->
            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-sm p-6">
                <h2 class="text-base font-semibold leading-7 text-zinc-900 dark:text-white">Assignment</h2>
                <div class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                    Current: <span class="font-medium text-zinc-900 dark:text-zinc-200">{{ $complaint->assignedTo?->name ?? 'Unassigned' }}</span>
                </div>
                
                <form method="POST" action="{{ route('admin.complaints.assign', $complaint) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="assigned_to" class="sr-only">Staff Member</label>
                        <select id="assigned_to" name="assigned_to" class="block w-full rounded-lg border-0 py-2 pl-3 pr-8 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 sm:text-sm sm:leading-6" required>
                            <option value="">Select staff</option>
                            @foreach ($staffUsers as $staff)
                                <option value="{{ $staff->id }}" @selected((int) old('assigned_to', $complaint->assigned_to) === $staff->id)>{{ $staff->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-white dark:bg-zinc-800 px-4 py-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100 border border-zinc-300 dark:border-zinc-600 shadow-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                        Reassign Complaint
                    </button>
                </form>
            </div>

            <!-- Status Form -->
            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-sm p-6">
                <h2 class="text-base font-semibold leading-7 text-zinc-900 dark:text-white">Update Status</h2>
                <form method="POST" action="{{ route('admin.complaints.update-status', $complaint) }}" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="block text-sm font-medium text-zinc-900 dark:text-zinc-200 mb-1.5">New Status</label>
                        <select id="status" name="status" class="block w-full rounded-lg border-0 py-2 pl-3 pr-8 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 sm:text-sm sm:leading-6" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(old('status', $complaint->status) === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-medium text-zinc-900 dark:text-zinc-200 mb-1.5">Note (optional)</label>
                        <textarea id="note" name="note" rows="3" placeholder="Add an internal note or reasoning..." class="block w-full rounded-lg border-0 py-2.5 px-3 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 shadow-sm sm:text-sm sm:leading-6">{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
