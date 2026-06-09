@extends('layouts.student')

@section('student-content')
<div class="max-w-3xl space-y-6">
    <div>
        <h1 class="page-heading">Submit Complaint</h1>
        <p class="page-subheading">Please provide detailed information to help us resolve the issue quickly.</p>
    </div>

    @if ($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <form method="POST" action="{{ route('student.complaints.store') }}" class="card">
        @csrf

        <div class="card-body space-y-8">
            <!-- Section: Basic Info -->
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <span class="flex size-8 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 text-sm font-bold">1</span>
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Basic Information</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Describe the issue you're facing.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="title" class="form-label">Issue Title</label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" required placeholder="e.g. Broken projector in Lecture Hall 3B" class="form-input">
                        @error('title')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" required class="form-select">
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
                        @error('category_id')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-zinc-200 dark:border-zinc-700"></div>

            <!-- Section: Location & Priority -->
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <span class="flex size-8 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 text-sm font-bold">2</span>
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Location & Priority</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Where did this happen and how urgent is it?</p>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="location" class="form-label">Location</label>
                        <input id="location" name="location" type="text" value="{{ old('location') }}" placeholder="e.g. Science Block, Room 204" class="form-input">
                        @error('location')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="priority" class="form-label">Priority Level</label>
                        <select id="priority" name="priority" required class="form-select">
                            <option value="">Select priority</option>
                            @foreach (['low', 'medium', 'high', 'critical'] as $priorityOption)
                                <option value="{{ $priorityOption }}" @selected(old('priority') === $priorityOption)>{{ ucfirst($priorityOption) }}</option>
                            @endforeach
                        </select>
                        @error('priority')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-zinc-200 dark:border-zinc-700"></div>

            <!-- Section: Description -->
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <span class="flex size-8 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 text-sm font-bold">3</span>
                    <div>
                        <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Description</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Provide as much detail as possible.</p>
                    </div>
                </div>

                <div>
                    <label for="description" class="sr-only">Description</label>
                    <textarea id="description" name="description" rows="6" required placeholder="Explain the problem in detail. Include what you were doing, when it happened, and any other relevant context..." class="form-input min-h-[140px]">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 px-6 py-5 bg-zinc-50 dark:bg-zinc-900/50 border-t border-zinc-200 dark:border-zinc-700 rounded-b-2xl">
            <a href="{{ route('student.complaints.index') }}" class="btn-ghost">Cancel</a>
            <button type="submit" class="btn-primary">
                <flux:icon.paper-airplane class="size-4" />
                Submit Complaint
            </button>
        </div>
    </form>
</div>
@endsection
