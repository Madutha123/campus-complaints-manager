@extends('layouts.admin')

@section('admin-content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">All Complaints</h1>
            <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400">Manage, reassign, and update campus complaints.</p>
        </div>
    </div>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <!-- Filters -->
    <div class="rounded-2xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-sm p-4">
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 items-end">
            <div>
                <label for="status" class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">Status</label>
                <select name="status" id="status" class="block w-full rounded-lg border-0 py-2 pl-3 pr-8 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 sm:text-sm sm:leading-6">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? null) === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="category_id" class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">Category</label>
                <select name="category_id" id="category_id" class="block w-full rounded-lg border-0 py-2 pl-3 pr-8 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 sm:text-sm sm:leading-6">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) ($filters['category_id'] ?? '') === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="department_id" class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">Department</label>
                <select name="department_id" id="department_id" class="block w-full rounded-lg border-0 py-2 pl-3 pr-8 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 sm:text-sm sm:leading-6">
                    <option value="">All Departments</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected((string) ($filters['department_id'] ?? '') === (string) $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="priority" class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">Priority</label>
                <select name="priority" id="priority" class="block w-full rounded-lg border-0 py-2 pl-3 pr-8 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 sm:text-sm sm:leading-6">
                    <option value="">All Priorities</option>
                    @foreach ($priorities as $priority)
                        <option value="{{ $priority }}" @selected(($filters['priority'] ?? null) === $priority)>{{ ucfirst($priority) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 rounded-lg bg-zinc-900 dark:bg-white px-3 py-2 text-sm font-semibold text-white dark:text-zinc-900 shadow-sm hover:bg-zinc-800 dark:hover:bg-zinc-200 transition">Filter</button>
                <a href="{{ route('admin.complaints.index') }}" class="flex-[0.5] rounded-lg bg-white dark:bg-zinc-800 px-3 py-2 text-sm font-semibold text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-700 text-center hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 text-left text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Ticket No</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Submitter</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Category</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Department</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Priority</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Status</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Assigned To</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Date</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($complaints as $complaint)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-zinc-900 dark:text-zinc-200">{{ $complaint->ticket_no }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600 dark:text-zinc-400">
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-xs font-medium text-zinc-600 dark:text-zinc-400">
                                        {{ substr($complaint->submitter?->name ?? '?', 0, 1) }}
                                    </div>
                                    {{ $complaint->submitter?->name ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600 dark:text-zinc-400">{{ $complaint->category?->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600 dark:text-zinc-400">{{ $complaint->department?->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap"><x-priority-badge :priority="$complaint->priority" /></td>
                            <td class="px-6 py-4 whitespace-nowrap"><x-status-badge :status="$complaint->status" /></td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600 dark:text-zinc-400">{{ $complaint->assignedTo?->name ?? 'Unassigned' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-500 dark:text-zinc-500">{{ optional($complaint->created_at)->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="rounded-md border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-2.5 py-1.5 text-xs font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">View</a>
                                    <a href="{{ route('admin.complaints.show', $complaint) }}#assignment-panel" class="rounded-md bg-indigo-50 dark:bg-indigo-500/10 px-2.5 py-1.5 text-xs font-semibold text-indigo-700 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition">Assign</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">No complaints found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($complaints->hasPages())
            <div class="border-t border-zinc-200 dark:border-zinc-700 px-6 py-4">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
