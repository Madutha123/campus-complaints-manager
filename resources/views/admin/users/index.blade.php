@extends('layouts.admin')

@section('admin-content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Registered Users</h1>
        <p class="mt-1 text-sm text-gray-600">View all users in the system.</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Name</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Role</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Department</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
                        <td class="px-4 py-3 capitalize text-gray-700">{{ $user->role }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $user->department?->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if ($user->is_active)
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ optional($user->created_at)->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
</div>
@endsection
