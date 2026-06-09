@extends('layouts.admin')

@section('admin-content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="page-heading">All Complaints</h1>
            <p class="page-subheading">Manage, reassign, and update campus complaints.</p>
        </div>
    </div>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <!-- Filters -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 items-end">
            <div>
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption }}" @selected(($filters['status'] ?? null) === $statusOption)>{{ ucfirst(str_replace('_', ' ', $statusOption)) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) ($filters['category_id'] ?? '') === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="department_id" class="form-label">Department</label>
                <select name="department_id" id="department_id" class="form-select">
                    <option value="">All Departments</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected((string) ($filters['department_id'] ?? '') === (string) $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="priority" class="form-label">Priority</label>
                <select name="priority" id="priority" class="form-select">
                    <option value="">All Priorities</option>
                    @foreach ($priorities as $priorityOption)
                        <option value="{{ $priorityOption }}" @selected(($filters['priority'] ?? null) === $priorityOption)>{{ ucfirst($priorityOption) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn-primary flex-1">Filter</button>
                <a href="{{ route('admin.complaints.index') }}" class="btn-secondary flex-[0.5] text-center">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="table-header">
                    <tr>
                        <th>Ticket No</th>
                        <th>Submitter</th>
                        <th>Category</th>
                        <th>Department</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @forelse ($complaints as $complaint)
                        <tr class="table-row table-row-accent">
                            <td class="table-cell-mono">{{ $complaint->ticket_no }}</td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-7 w-7 rounded-full bg-indigo-100 dark:bg-indigo-500/10 flex items-center justify-center text-xs font-semibold text-indigo-700 dark:text-indigo-400">
                                        {{ substr($complaint->submitter?->name ?? '?', 0, 1) }}
                                    </div>
                                    <span>{{ $complaint->submitter?->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">{{ $complaint->category?->name ?? '-' }}</td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">{{ $complaint->department?->name ?? '-' }}</td>
                            <td class="table-cell"><x-priority-badge :priority="$complaint->priority" /></td>
                            <td class="table-cell"><x-status-badge :status="$complaint->status" /></td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">{{ $complaint->assignedTo?->name ?? 'Unassigned' }}</td>
                            <td class="table-cell text-zinc-500 dark:text-zinc-500">{{ optional($complaint->created_at)->format('M d, Y') }}</td>
                            <td class="table-cell text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn-ghost text-xs">View</a>
                                    <a href="{{ route('admin.complaints.show', $complaint) }}#assignment-panel" class="btn-ghost text-xs text-indigo-600 dark:text-indigo-400">Assign</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="table-cell text-center text-zinc-500 dark:text-zinc-400 py-16">No complaints found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($complaints->hasPages())
            <div class="border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex items-center justify-between text-sm">
                <p class="text-zinc-500 dark:text-zinc-400">
                    Showing {{ $complaints->firstItem() }}–{{ $complaints->lastItem() }} of {{ $complaints->total() }}
                </p>
                <div class="pagination-links">
                    {{ $complaints->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
