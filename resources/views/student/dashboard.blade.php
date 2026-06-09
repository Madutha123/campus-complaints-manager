@extends('layouts.student')

@section('student-content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Student Dashboard</h1>
            <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400">Track and manage your campus complaints.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('student.complaints.create') }}" class="rounded-lg bg-zinc-900 dark:bg-white px-4 py-2 text-sm font-semibold text-white dark:text-zinc-900 shadow-sm hover:bg-zinc-800 dark:hover:bg-zinc-200 transition">
                <span class="flex items-center gap-2">
                    <flux:icon.plus class="size-4" />
                    Submit Complaint
                </span>
            </a>
        </div>
    </div>

    <!-- KPIs -->
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
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
    </div>

    <!-- Recent Complaints -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold leading-7 text-zinc-900 dark:text-white">Recent Complaints</h2>
            <a href="{{ route('student.complaints.index') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 transition">View all</a>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($complaints as $complaint)
                <x-complaint-card :complaint="$complaint" />
            @empty
                <div class="md:col-span-2 xl:col-span-3 flex flex-col items-center justify-center rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/20 p-12 text-center">
                    <flux:icon.inbox class="size-8 text-zinc-400 mb-3" />
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">No complaints yet</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">You haven't submitted any complaints. Get started by submitting a new one.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
