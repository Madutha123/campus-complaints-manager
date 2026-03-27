@extends('layouts.student')

@section('student-content')
<div class="max-w-3xl space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">Submit Complaint</h1>

    @if ($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <form method="POST" action="{{ route('student.complaints.store') }}" class="rounded-xl border border-gray-200 bg-white p-6 space-y-5">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}" required class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900">
            @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select id="category_id" name="category_id" required class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                <option value="">Select category</option>
                @foreach ($categories as $department => $departmentCategories)
                    <optgroup label="{{ $department }}">
                        @foreach ($departmentCategories as $category)
                            <option value="{{ $category->id }}" @selected((int) old('category_id') === $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error('category_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="6" required class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900">{{ old('description') }}</textarea>
            @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input id="location" name="location" type="text" value="{{ old('location') }}" class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                @error('location')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <select id="priority" name="priority" required class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                    <option value="">Select priority</option>
                    @foreach (['low', 'medium', 'high', 'critical'] as $priority)
                        <option value="{{ $priority }}" @selected(old('priority') === $priority)>{{ ucfirst($priority) }}</option>
                    @endforeach
                </select>
                @error('priority')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <button type="submit" class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black">Submit Complaint</button>
    </form>
</div>
@endsection
