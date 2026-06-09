@extends('layouts.admin')

@section('admin-content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Admin Dashboard</h1>
            <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400">Campus-wide overview of complaint volume and status.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reports.index') }}" class="rounded-lg bg-white dark:bg-zinc-800 px-4 py-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100 shadow-sm ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 hover:bg-zinc-50 transition">
                View Reports
            </a>
            <a href="{{ route('admin.complaints.index') }}" class="rounded-lg bg-zinc-900 dark:bg-white px-4 py-2 text-sm font-semibold text-white dark:text-zinc-900 shadow-sm hover:bg-zinc-800 dark:hover:bg-zinc-200 transition">
                All Complaints
            </a>
        </div>
    </div>

    <!-- KPIs -->
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 p-6 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700 transition hover:shadow-md">
            <dt class="flex flex-row items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>Total</span>
                <flux:icon.table-cells class="size-5 text-zinc-400" />
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['total'] }}</dd>
        </div>
        
        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 p-6 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700 transition hover:shadow-md">
            <div class="absolute right-0 top-0 h-full w-1 bg-amber-400"></div>
            <dt class="flex flex-row items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>Pending</span>
                <flux:icon.clock class="size-5 text-amber-500" />
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['pending'] }}</dd>
        </div>
        
        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 p-6 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700 transition hover:shadow-md">
            <div class="absolute right-0 top-0 h-full w-1 bg-blue-500"></div>
            <dt class="flex flex-row items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>In Progress</span>
                <flux:icon.play-circle class="size-5 text-blue-500" />
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['in_progress'] }}</dd>
        </div>
        
        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 p-6 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700 transition hover:shadow-md">
            <div class="absolute right-0 top-0 h-full w-1 bg-emerald-500"></div>
            <dt class="flex flex-row items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>Resolved</span>
                <flux:icon.check-circle class="size-5 text-emerald-500" />
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['resolved'] }}</dd>
        </div>
        
        <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 p-6 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700 transition hover:shadow-md">
            <div class="absolute right-0 top-0 h-full w-1 bg-rose-500"></div>
            <dt class="flex flex-row items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>Overdue</span>
                <flux:icon.exclamation-circle class="size-5 text-rose-500" />
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['overdue'] }}</dd>
        </div>
    </div>

    <!-- Recent Activity -->
    <div>
        <h2 class="text-base font-semibold leading-7 text-zinc-900 dark:text-white mb-4">Latest Submissions</h2>
        <div class="overflow-hidden rounded-2xl bg-white dark:bg-zinc-800 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 text-left text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-6 py-4 font-medium text-zinc-500 dark:text-zinc-400">Ticket No</th>
                        <th class="px-6 py-4 font-medium text-zinc-500 dark:text-zinc-400">Title</th>
                        <th class="px-6 py-4 font-medium text-zinc-500 dark:text-zinc-400">Submitter</th>
                        <th class="px-6 py-4 font-medium text-zinc-500 dark:text-zinc-400">Status</th>
                        <th class="px-6 py-4 font-medium text-zinc-500 dark:text-zinc-400">Date</th>
                        <th class="px-6 py-4 font-medium text-zinc-500 dark:text-zinc-400 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($recentComplaints as $complaint)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-zinc-900 dark:text-zinc-200">{{ $complaint->ticket_no }}</td>
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-200">{{ $complaint->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-600 dark:text-zinc-400">
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-xs font-medium text-zinc-600 dark:text-zinc-400">
                                        {{ substr($complaint->submitter?->name ?? '?', 0, 1) }}
                                    </div>
                                    {{ $complaint->submitter?->name ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"><x-status-badge :status="$complaint->status" /></td>
                            <td class="px-6 py-4 whitespace-nowrap text-zinc-500 dark:text-zinc-400">{{ optional($complaint->created_at)->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 transition">View<span class="sr-only">, {{ $complaint->ticket_no }}</span></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center text-zinc-500">No complaints yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
