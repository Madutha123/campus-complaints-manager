@extends('layouts.admin')

@section('admin-content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="mt-1 text-sm text-gray-600">Overall complaints performance and latest submissions.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-xl border border-gray-200 bg-white p-5"><p class="text-sm text-gray-500">Total</p><p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p></div>
        <div class="rounded-xl border border-yellow-200 bg-white p-5"><p class="text-sm text-yellow-700">Pending</p><p class="mt-2 text-3xl font-bold text-yellow-800">{{ $stats['pending'] }}</p></div>
        <div class="rounded-xl border border-orange-200 bg-white p-5"><p class="text-sm text-orange-700">In Progress</p><p class="mt-2 text-3xl font-bold text-orange-800">{{ $stats['in_progress'] }}</p></div>
        <div class="rounded-xl border border-green-200 bg-white p-5"><p class="text-sm text-green-700">Resolved</p><p class="mt-2 text-3xl font-bold text-green-800">{{ $stats['resolved'] }}</p></div>
        <div class="rounded-xl border border-red-200 bg-white p-5"><p class="text-sm text-red-700">Overdue</p><p class="mt-2 text-3xl font-bold text-red-800">{{ $stats['overdue'] }}</p></div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Ticket No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Title</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Submitter</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($recentComplaints as $complaint)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $complaint->ticket_no }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->title }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $complaint->submitter?->name ?? '-' }}</td>
                        <td class="px-4 py-3"><x-status-badge :status="$complaint->status" /></td>
                        <td class="px-4 py-3 text-gray-600">{{ optional($complaint->created_at)->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No complaints yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
