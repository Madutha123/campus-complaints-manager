@extends('layouts.admin')

@section('admin-content')
<div class="space-y-8">
    <div>
        <h1 class="page-heading">Categories</h1>
        <p class="page-subheading">Create and manage categories under departments.</p>
    </div>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if ($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <!-- Create Form -->
    <form method="POST" action="{{ route('admin.categories.store') }}" class="card">
        @csrf
        <div class="card-header">
            <div class="flex items-center gap-2">
                <flux:icon.plus-circle class="size-4 text-indigo-600 dark:text-indigo-400" />
                <h2 class="section-heading">Create Category</h2>
            </div>
        </div>
        <div class="card-body space-y-5">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="name" class="form-label">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required placeholder="e.g. Network Issue" class="form-input">
                </div>

                <div>
                    <label for="department_id" class="form-label">Department</label>
                    <select id="department_id" name="department_id" required class="form-select">
                        <option value="">Select department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ (string) old('department_id') === (string) $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="sla_hours" class="form-label">SLA Hours</label>
                    <input id="sla_hours" name="sla_hours" type="number" min="1" max="720" value="{{ old('sla_hours', 48) }}" required class="form-input">
                </div>
                <div class="flex items-end pb-1">
                    <label class="inline-flex items-center gap-2.5 text-sm font-medium text-zinc-700 dark:text-zinc-300 cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="size-4 rounded border-zinc-300 dark:border-zinc-600 text-indigo-600 focus:ring-indigo-600 dark:bg-zinc-900 dark:focus:ring-indigo-500">
                        Active
                    </label>
                </div>
            </div>

            <div>
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Brief description of this category..." class="form-input min-h-[80px]">{{ old('description') }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary">
                    <flux:icon.plus class="size-4" />
                    Create Category
                </button>
            </div>
        </div>
    </form>

    <!-- Categories Table -->
    <div class="table-wrapper">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="table-header">
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>SLA Hours</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @forelse ($categories as $category)
                        <tr class="table-row table-row-accent">
                            <td class="table-cell font-medium text-zinc-900 dark:text-zinc-200">{{ $category->name }}</td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">{{ $category->department?->name ?? '-' }}</td>
                            <td class="table-cell">
                                <span class="inline-flex items-center gap-1.5 text-sm text-zinc-600 dark:text-zinc-400">
                                    <flux:icon.clock class="size-3.5" />
                                    {{ $category->sla_hours }}h
                                </span>
                            </td>
                            <td class="table-cell">
                                @if ($category->is_active)
                                    <span class="badge bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/20">
                                        <span class="badge-dot bg-emerald-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-zinc-50 text-zinc-700 ring-zinc-600/10 dark:bg-zinc-400/10 dark:text-zinc-400 dark:ring-zinc-400/20">
                                        <span class="badge-dot bg-zinc-400"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table-cell text-center text-zinc-500 dark:text-zinc-400 py-16">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($categories, 'hasPages') && $categories->hasPages())
            <div class="border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex items-center justify-between text-sm">
                <p class="text-zinc-500 dark:text-zinc-400">
                    Showing {{ $categories->firstItem() }}–{{ $categories->lastItem() }} of {{ $categories->total() }}
                </p>
                <div class="pagination-links">
                    {{ $categories->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
