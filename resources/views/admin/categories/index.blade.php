@extends('layouts.admin')

@section('admin-content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
        <p class="mt-1 text-sm text-gray-600">Create and manage categories under departments.</p>
    </div>

    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if ($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <form method="POST" action="{{ route('admin.categories.store') }}" class="rounded-xl border border-gray-200 bg-white p-6 space-y-4">
        @csrf
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Create Category</h2>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900">
            </div>

            <div>
                <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                <select id="department_id" name="department_id" required class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                    <option value="">Select department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ (string) old('department_id') === (string) $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label for="sla_hours" class="block text-sm font-medium text-gray-700">SLA Hours</label>
                <input id="sla_hours" name="sla_hours" type="number" min="1" max="720" value="{{ old('sla_hours', 48) }}" required class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900">
            </div>
            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="rounded border border-gray-300 text-gray-900 focus:ring-gray-900">
                    Active
                </label>
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="3" class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-black">Create Category</button>
    </form>

    <div class="rounded-xl border border-gray-200 bg-white overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Name</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Department</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">SLA Hours</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $category->department?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $category->sla_hours }}</td>
                        <td class="px-4 py-3">
                            @if ($category->is_active)
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $categories->links() }}
</div>
@endsection
