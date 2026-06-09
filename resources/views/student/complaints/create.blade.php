@extends('layouts.student')

@section('student-content')
<div class="max-w-3xl space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Submit Complaint</h1>
        <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400">Please provide detailed information to help us resolve the issue quickly.</p>
    </div>

    @if ($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <form method="POST" action="{{ route('student.complaints.store') }}" class="rounded-2xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-sm p-6 sm:p-8">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-zinc-900 dark:text-zinc-200 mb-2">Issue Title</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}" required placeholder="Brief description of the issue" class="block w-full rounded-lg border-0 py-2.5 px-3 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 shadow-sm sm:text-sm sm:leading-6">
                @error('title')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-zinc-900 dark:text-zinc-200 mb-2">Category</label>
                <select id="category_id" name="category_id" required class="block w-full rounded-lg border-0 py-2.5 px-3 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 shadow-sm sm:text-sm sm:leading-6">
                    <option value="">Select a category</option>
                    @foreach ($categories as $department => $departmentCategories)
                        <optgroup label="{{ $department }}" class="font-semibold text-zinc-500">
                            @foreach ($departmentCategories as $category)
                                <option value="{{ $category->id }}" @selected((int) old('category_id') === $category->id) class="text-zinc-900 dark:text-zinc-100 font-normal">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('category_id')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="location" class="block text-sm font-medium text-zinc-900 dark:text-zinc-200 mb-2">Location</label>
                    <input id="location" name="location" type="text" value="{{ old('location') }}" placeholder="e.g. Science Block, Room 204" class="block w-full rounded-lg border-0 py-2.5 px-3 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 shadow-sm sm:text-sm sm:leading-6">
                    @error('location')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-zinc-900 dark:text-zinc-200 mb-2">Priority Level</label>
                    <select id="priority" name="priority" required class="block w-full rounded-lg border-0 py-2.5 px-3 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 shadow-sm sm:text-sm sm:leading-6">
                        <option value="">Select priority</option>
                        @foreach (['low', 'medium', 'high', 'critical'] as $priority)
                            <option value="{{ $priority }}" @selected(old('priority') === $priority)>{{ ucfirst($priority) }}</option>
                        @endforeach
                    </select>
                    @error('priority')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-zinc-900 dark:text-zinc-200 mb-2">Description</label>
                <textarea id="description" name="description" rows="5" required placeholder="Explain the problem in detail..." class="block w-full rounded-lg border-0 py-2.5 px-3 text-zinc-900 dark:text-zinc-100 ring-1 ring-inset ring-zinc-300 dark:ring-zinc-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 bg-white dark:bg-zinc-900 shadow-sm sm:text-sm sm:leading-6">{{ old('description') }}</textarea>
                @error('description')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-zinc-200 dark:border-zinc-700">
            <a href="{{ route('student.complaints.index') }}" class="text-sm font-semibold leading-6 text-zinc-900 dark:text-zinc-200 hover:text-zinc-600 dark:hover:text-zinc-400">Cancel</a>
            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                Submit Complaint
            </button>
        </div>
    </form>
</div>
@endsection
