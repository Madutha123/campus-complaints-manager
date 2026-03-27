@extends('layouts.staff')

@section('staff-content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Staff Dashboard</h1>
        <p class="mt-1 text-sm text-gray-600">Overview of complaints assigned to you.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <p class="text-sm font-medium text-gray-500">Assigned to me</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['assigned'] }}</p>
        </div>
        <div class="rounded-xl border border-orange-200 bg-white p-5">
            <p class="text-sm font-medium text-orange-700">In Progress</p>
            <p class="mt-2 text-3xl font-bold text-orange-800">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="rounded-xl border border-green-200 bg-white p-5">
            <p class="text-sm font-medium text-green-700">Resolved today</p>
            <p class="mt-2 text-3xl font-bold text-green-800">{{ $stats['resolved_today'] }}</p>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Ticket No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Title</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Submitter</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($recentComplaints as $complaint)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $complaint->ticket_no }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->title }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->submitter?->name ?? '-' }}</td>
                        <td class="px-4 py-3"><x-status-badge :status="$complaint->status" /></td>
                        <td class="px-4 py-3"><a href="{{ route('staff.complaints.show', $complaint) }}" class="rounded-md border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No assigned complaints found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
