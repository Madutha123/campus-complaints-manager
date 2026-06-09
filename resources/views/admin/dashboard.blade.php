@extends('layouts.admin')

@section('admin-content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="page-heading">Admin Dashboard</h1>
            <p class="page-subheading">Campus-wide overview of complaint volume and status.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.reports.index') }}" class="btn-secondary">
                <flux:icon.chart-bar class="size-4" />
                View Reports
            </a>
            <a href="{{ route('admin.complaints.index') }}" class="btn-primary">
                <flux:icon.arrow-right class="size-4" />
                All Complaints
            </a>
        </div>
    </div>

    <!-- KPIs -->
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-5">
        <div class="stat-card bg-white dark:bg-zinc-800 ring-zinc-200 dark:ring-zinc-700">
            <dt class="flex items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>Total</span>
                <span class="stat-icon bg-zinc-100 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400">
                    <flux:icon.table-cells class="size-5" />
                </span>
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['total'] }}</dd>
        </div>

        <div class="stat-card bg-white dark:bg-zinc-800 ring-zinc-200 dark:ring-zinc-700">
            <span class="stat-accent bg-amber-400"></span>
            <dt class="flex items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>Pending</span>
                <span class="stat-icon bg-amber-50 dark:bg-amber-500/10 text-amber-500">
                    <flux:icon.clock class="size-5" />
                </span>
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['pending'] }}</dd>
        </div>

        <div class="stat-card bg-white dark:bg-zinc-800 ring-zinc-200 dark:ring-zinc-700">
            <span class="stat-accent bg-blue-500"></span>
            <dt class="flex items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>In Progress</span>
                <span class="stat-icon bg-blue-50 dark:bg-blue-500/10 text-blue-500">
                    <flux:icon.play-circle class="size-5" />
                </span>
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['in_progress'] }}</dd>
        </div>

        <div class="stat-card bg-white dark:bg-zinc-800 ring-zinc-200 dark:ring-zinc-700">
            <span class="stat-accent bg-emerald-500"></span>
            <dt class="flex items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>Resolved</span>
                <span class="stat-icon bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500">
                    <flux:icon.check-circle class="size-5" />
                </span>
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['resolved'] }}</dd>
        </div>

        <div class="stat-card bg-white dark:bg-zinc-800 ring-zinc-200 dark:ring-zinc-700">
            <span class="stat-accent bg-rose-500"></span>
            <dt class="flex items-center justify-between text-sm font-medium text-zinc-500 dark:text-zinc-400">
                <span>Overdue</span>
                <span class="stat-icon bg-rose-50 dark:bg-rose-500/10 text-rose-500">
                    <flux:icon.exclamation-circle class="size-5" />
                </span>
            </dt>
            <dd class="mt-3 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $stats['overdue'] }}</dd>
        </div>
    </div>

    <!-- Recent Activity -->
    <div>
        <div class="flex items-center justify-between mb-5">
            <h2 class="section-heading">Latest Submissions</h2>
            <a href="{{ route('admin.complaints.index') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition">View all</a>
        </div>
        <div class="table-wrapper">
            <table class="min-w-full text-left text-sm">
                <thead class="table-header">
                    <tr>
                        <th>Ticket No</th>
                        <th>Title</th>
                        <th>Submitter</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @forelse ($recentComplaints as $complaint)
                        <tr class="table-row table-row-accent">
                            <td class="table-cell-mono">{{ $complaint->ticket_no }}</td>
                            <td class="table-cell font-medium text-zinc-900 dark:text-zinc-200">{{ $complaint->title }}</td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-7 w-7 rounded-full bg-indigo-100 dark:bg-indigo-500/10 flex items-center justify-center text-xs font-semibold text-indigo-700 dark:text-indigo-400">
                                        {{ substr($complaint->submitter?->name ?? '?', 0, 1) }}
                                    </div>
                                    <span>{{ $complaint->submitter?->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="table-cell"><x-status-badge :status="$complaint->status" /></td>
                            <td class="table-cell text-zinc-500 dark:text-zinc-400">{{ optional($complaint->created_at)->format('M d, Y') }}</td>
                            <td class="table-cell text-right">
                                <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn-ghost text-xs">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-cell text-center text-zinc-500 dark:text-zinc-400 py-12">No complaints yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
