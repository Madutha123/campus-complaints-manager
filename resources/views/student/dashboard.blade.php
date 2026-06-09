@extends('layouts.student')

@section('student-content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="page-heading">Student Dashboard</h1>
            <p class="page-subheading">Track and manage your campus complaints.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('student.complaints.create') }}" class="btn-primary">
                <flux:icon.plus class="size-4" />
                Submit Complaint
            </a>
        </div>
    </div>

    <!-- KPIs -->
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
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
    </div>

    <!-- Recent Complaints -->
    <div>
        <div class="flex items-center justify-between mb-5">
            <h2 class="section-heading">Recent Complaints</h2>
            <a href="{{ route('student.complaints.index') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition">View all</a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($complaints as $complaint)
                <x-complaint-card :complaint="$complaint" />
            @empty
                <div class="md:col-span-2 xl:col-span-3 flex flex-col items-center justify-center rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/20 p-12 text-center">
                    <div class="size-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4">
                        <flux:icon.inbox class="size-6 text-zinc-400" />
                    </div>
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">No complaints yet</h3>
                    <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400 max-w-sm">You haven't submitted any complaints. Get started by submitting a new one.</p>
                    <a href="{{ route('student.complaints.create') }}" class="btn-primary mt-5">
                        <flux:icon.plus class="size-4" />
                        Submit Complaint
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
