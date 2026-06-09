@extends('layouts.staff')

@section('staff-content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="page-heading">Assigned Complaints</h1>
            <p class="page-subheading">View and update complaints assigned to you.</p>
        </div>
    </div>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <!-- Filters -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('staff.complaints.index') }}" class="flex flex-col sm:flex-row items-end gap-4 w-full sm:w-auto">
            <div class="w-full sm:w-72">
                <label for="status" class="form-label">Filter by status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ ucfirst(str_replace('_', ' ', $statusOption)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <button type="submit" class="btn-primary flex-1 sm:flex-none">Apply</button>
                @if($status)
                    <a href="{{ route('staff.complaints.index') }}" class="btn-secondary flex-1 sm:flex-none">Clear</a>
                @endif
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
                        <th>Title</th>
                        <th>Category</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @forelse ($complaints as $complaint)
                        <tr class="table-row table-row-accent">
                            <td class="table-cell-mono">{{ $complaint->ticket_no }}</td>
                            <td class="table-cell font-medium text-zinc-900 dark:text-zinc-200">{{ $complaint->title }}</td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">{{ $complaint->category?->name ?? '-' }}</td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">{{ $complaint->department?->name ?? '-' }}</td>
                            <td class="table-cell"><x-status-badge :status="$complaint->status" /></td>
                            <td class="table-cell text-zinc-500 dark:text-zinc-400">{{ optional($complaint->created_at)->format('M d, Y') }}</td>
                            <td class="table-cell text-right">
                                <a href="{{ route('staff.complaints.show', $complaint) }}" class="btn-ghost text-xs">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="table-cell text-center text-zinc-500 dark:text-zinc-400 py-16">No assigned complaints found.</td>
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
