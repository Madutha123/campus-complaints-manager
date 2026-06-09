@extends('layouts.admin')

@section('admin-content')
<div class="space-y-8">
    <div>
        <h1 class="page-heading">Registered Users</h1>
        <p class="page-subheading">View all users in the system.</p>
    </div>

    <div class="table-wrapper">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="table-header">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    @forelse ($users as $user)
                        <tr class="table-row table-row-accent">
                            <td class="table-cell">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-7 w-7 rounded-full bg-indigo-100 dark:bg-indigo-500/10 flex items-center justify-center text-xs font-semibold text-indigo-700 dark:text-indigo-400">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-zinc-900 dark:text-zinc-200">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">{{ $user->email }}</td>
                            <td class="table-cell">
                                <span class="badge bg-zinc-100 text-zinc-700 ring-zinc-600/10 dark:bg-zinc-700 dark:text-zinc-300 dark:ring-zinc-500/20 capitalize">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="table-cell text-zinc-600 dark:text-zinc-400">{{ $user->department?->name ?? '-' }}</td>
                            <td class="table-cell">
                                @if ($user->is_active)
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
                            <td class="table-cell text-zinc-500 dark:text-zinc-400">{{ optional($user->created_at)->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-cell text-center text-zinc-500 dark:text-zinc-400 py-16">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($users, 'hasPages') && $users->hasPages())
            <div class="border-t border-zinc-200 dark:border-zinc-700 px-6 py-4 flex items-center justify-between text-sm">
                <p class="text-zinc-500 dark:text-zinc-400">
                    Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }}
                </p>
                <div class="pagination-links">
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
