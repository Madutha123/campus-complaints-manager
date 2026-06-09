@extends('layouts.staff')

@section('staff-content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Assigned Complaints</h1>
            <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400">View and update complaints assigned to you.</p>
        </div>
    </div>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    <!-- Filters -->
    <div class="rounded-2xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-sm p-4">
        <form method="GET" action="{{ route('staff.complaints.index') }}" class="flex flex-col sm:flex-row items-end gap-4 w-full sm:w-auto">
            <div class="w-full sm:w-64">
                <label for="status" class="block text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">Filter by status</label>
                <select id="status" name="status" class="block w-full rounded-lg border-0 py-2 pl-3 pr-8 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 sm:text-sm sm:leading-6">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ ucfirst(str_replace('_', ' ', $statusOption)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <button type="submit" class="flex-1 sm:flex-none rounded-lg bg-zinc-900 dark:bg-white px-4 py-2 text-sm font-semibold text-white dark:text-zinc-900 shadow-sm hover:bg-zinc-800 dark:hover:bg-zinc-200 transition">Apply</button>
                @if($status)
                    <a href="{{ route('staff.complaints.index') }}" class="flex-1 sm:flex-none rounded-lg bg-white dark:bg-zinc-800 px-4 py-2 text-sm font-semibold text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-700 text-center hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">Clear</a>
                @endif
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
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Title</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Category</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Department</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Status</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200">Date</th>
                        <th class="px-6 py-4 font-semibold text-zinc-900 dark:text-zinc-200 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($complaints as $complaint)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-zinc-900 dark:text-zinc-200">{{ $complaint->ticket_no }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-zinc-900 dark:text-zinc-200">{{ $complaint->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600 dark:text-zinc-400">{{ $complaint->category?->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600 dark:text-zinc-400">{{ $complaint->department?->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap"><x-status-badge :status="$complaint->status" /></td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-500 dark:text-zinc-400">{{ optional($complaint->created_at)->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('staff.complaints.show', $complaint) }}" class="rounded-md border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-2.5 py-1.5 text-xs font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">No assigned complaints found.</td></tr>
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
