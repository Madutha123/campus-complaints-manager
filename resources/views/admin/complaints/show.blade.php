@extends('layouts.admin')

@section('admin-content')
<div class="space-y-6">
    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if ($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2 space-y-6">
            <div class="rounded-xl border border-gray-200 bg-white p-6">
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

                <dl class="mt-5 grid gap-3 text-sm md:grid-cols-2">
                    <div><dt class="text-gray-500">Submitter</dt><dd class="font-medium text-gray-800">{{ $complaint->submitter?->name ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Assigned To</dt><dd class="font-medium text-gray-800">{{ $complaint->assignedTo?->name ?? 'Unassigned' }}</dd></div>
                    <div><dt class="text-gray-500">Category</dt><dd class="font-medium text-gray-800">{{ $complaint->category?->name ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Department</dt><dd class="font-medium text-gray-800">{{ $complaint->department?->name ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Location</dt><dd class="font-medium text-gray-800">{{ $complaint->location ?? '-' }}</dd></div>
                    <div><dt class="text-gray-500">Due Date</dt><dd class="font-medium text-gray-800">{{ optional($complaint->due_date)->format('M d, Y h:i A') ?? '-' }}</dd></div>
                </dl>

                <div class="mt-5 border-t border-gray-100 pt-5">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Description</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-700">{{ $complaint->description }}</p>
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
                            @if ($log->old_status || $log->new_status)
                                <p class="mt-1 text-xs text-gray-600">{{ $log->old_status ?? '-' }} → {{ $log->new_status ?? '-' }}</p>
                            @endif
                            @if ($log->note)
                                <p class="mt-1 text-sm text-gray-600">{{ $log->note }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No activity logs.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div id="assignment-panel" class="space-y-6">
            <div class="rounded-xl border border-gray-200 bg-white p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Assign to Staff</h2>
                <form method="POST" action="{{ route('admin.complaints.assign', $complaint) }}" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="assigned_to" class="block text-sm font-medium text-gray-700">Staff Member</label>
                        <select id="assigned_to" name="assigned_to" class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                            <option value="">Select staff</option>
                            @foreach ($staffUsers as $staff)
                                <option value="{{ $staff->id }}" @selected((int) old('assigned_to', $complaint->assigned_to) === $staff->id)>{{ $staff->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">Assign Complaint</button>
                </form>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Change Status</h2>
                <form method="POST" action="{{ route('admin.complaints.update-status', $complaint) }}" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">New Status</label>
                        <select id="status" name="status" class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(old('status', $complaint->status) === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700">Note (optional)</label>
                        <textarea id="note" name="note" rows="3" class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-black">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
