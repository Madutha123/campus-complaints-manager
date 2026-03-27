@extends('layouts.staff')

@section('staff-content')
<div class="space-y-6">
    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if ($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $complaint->ticket_no }}</p>
                <h1 class="mt-1 text-2xl font-bold text-gray-900">{{ $complaint->title }}</h1>
            </div>
            <div class="flex items-center gap-2">
                <x-status-badge :status="$complaint->status" />
                <x-priority-badge :priority="$complaint->priority" />
            </div>
        </div>

        <dl class="mt-5 grid gap-3 text-sm md:grid-cols-2">
            <div><dt class="text-gray-500">Submitter</dt><dd class="font-medium text-gray-800">{{ $complaint->submitter?->name ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Category</dt><dd class="font-medium text-gray-800">{{ $complaint->category?->name ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Department</dt><dd class="font-medium text-gray-800">{{ $complaint->department?->name ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Location</dt><dd class="font-medium text-gray-800">{{ $complaint->location ?? '-' }}</dd></div>
        </dl>

        <div class="mt-5 border-t border-gray-100 pt-5">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Description</h2>
            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-gray-700">{{ $complaint->description }}</p>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Update Status</h2>
        <form method="POST" action="{{ route('staff.complaints.update-status', $complaint) }}" class="mt-4 space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">New Status</label>
                <select id="status" name="status" class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900" required>
                    @foreach ($statusOptions as $statusOption)
                        <option value="{{ $statusOption }}" @selected(old('status', $complaint->status) === $statusOption)>{{ ucfirst(str_replace('_', ' ', $statusOption)) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea id="note" name="note" rows="4" class="mt-1 w-full rounded-lg border-gray-300 focus:border-gray-900 focus:ring-gray-900">{{ old('note') }}</textarea>
            </div>

            <button type="submit" class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black">Update Status</button>
        </form>
    </div>
</div>
@endsection
