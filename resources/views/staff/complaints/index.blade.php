@extends('layouts.staff')

@section('staff-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Assigned Complaints</h1>
    </div>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <form method="GET" action="{{ route('staff.complaints.index') }}" class="rounded-xl border border-gray-200 bg-white p-4">
        <div class="flex items-end gap-3">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Filter by status</label>
                <select id="status" name="status" class="mt-1 rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ ucfirst(str_replace('_', ' ', $statusOption)) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-black transition">Apply</button>
        </div>
    </form>

    <div class="rounded-xl border border-gray-200 bg-white overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Ticket No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Title</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Category</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Department</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Date</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($complaints as $complaint)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $complaint->ticket_no }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->title }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->category?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->department?->name ?? '-' }}</td>
                        <td class="px-4 py-3"><x-status-badge :status="$complaint->status" /></td>
                        <td class="px-4 py-3 text-gray-600">{{ optional($complaint->created_at)->format('M d, Y') }}</td>
                        <td class="px-4 py-3"><a href="{{ route('staff.complaints.show', $complaint) }}" class="rounded-md border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">No assigned complaints found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $complaints->links() }}
</div>
@endsection
