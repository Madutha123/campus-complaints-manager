@extends('layouts.student')

@section('student-content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Student Dashboard</h1>
        <p class="mt-1 text-sm text-gray-600">Overview of your complaints.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <p class="text-sm font-medium text-gray-500">Total</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-xl border border-yellow-200 bg-white p-5">
            <p class="text-sm font-medium text-yellow-700">Pending</p>
            <p class="mt-2 text-3xl font-bold text-yellow-800">{{ $stats['pending'] }}</p>
        </div>
        <div class="rounded-xl border border-orange-200 bg-white p-5">
            <p class="text-sm font-medium text-orange-700">In Progress</p>
            <p class="mt-2 text-3xl font-bold text-orange-800">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="rounded-xl border border-green-200 bg-white p-5">
            <p class="text-sm font-medium text-green-700">Resolved</p>
            <p class="mt-2 text-3xl font-bold text-green-800">{{ $stats['resolved'] }}</p>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">Last 5 Complaints</h2>
        <a href="{{ route('student.complaints.index') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">View all</a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($complaints as $complaint)
            <x-complaint-card :complaint="$complaint" />
        @empty
            <div class="md:col-span-2 xl:col-span-3 rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-sm text-gray-500">
                You have not submitted complaints yet.
            </div>
        @endforelse
    </div>
</div>
@endsection
