@extends('layouts.admin')

@section('admin-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">All Complaints</h1>
    </div>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <form method="GET" action="{{ route('admin.complaints.index') }}" class="rounded-xl border border-gray-200 bg-white p-4">
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
            <select name="status" class="rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">
                <option value="">All Statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? null) === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                @endforeach
            </select>

            <select name="category_id" class="rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) ($filters['category_id'] ?? '') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>

            <select name="department_id" class="rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">
                <option value="">All Departments</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected((string) ($filters['department_id'] ?? '') === (string) $department->id)>{{ $department->name }}</option>
                @endforeach
            </select>

            <select name="priority" class="rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900">
                <option value="">All Priorities</option>
                @foreach ($priorities as $priority)
                    <option value="{{ $priority }}" @selected(($filters['priority'] ?? null) === $priority)>{{ ucfirst($priority) }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-black transition">Filter</button>
                <a href="{{ route('admin.complaints.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Reset</a>
            </div>
        </div>
    </form>

    <div class="rounded-xl border border-gray-200 bg-white overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Ticket No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Submitter</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Category</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Department</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Priority</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Assigned To</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Date</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($complaints as $complaint)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $complaint->ticket_no }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->submitter?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->category?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->department?->name ?? '-' }}</td>
                        <td class="px-4 py-3"><x-priority-badge :priority="$complaint->priority" /></td>
                        <td class="px-4 py-3"><x-status-badge :status="$complaint->status" /></td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->assignedTo?->name ?? 'Unassigned' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ optional($complaint->created_at)->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.complaints.show', $complaint) }}" class="rounded-md border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">View</a>
                                <a href="{{ route('admin.complaints.show', $complaint) }}#assignment-panel" class="rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-700">Assign</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="px-4 py-8 text-center text-gray-500">No complaints found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $complaints->links() }}
</div>
@endsection
