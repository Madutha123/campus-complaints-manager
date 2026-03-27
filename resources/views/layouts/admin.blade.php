@extends('layouts.app')

@section('content')
<div class="flex flex-1 overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0">
        <nav class="p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Dashboard
            </a>
            <a href="{{ Route::has('admin.complaints.index') ? route('admin.complaints.index') : '#' }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.complaints.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Complaints
            </a>
            <a href="{{ Route::has('admin.users.index') ? route('admin.users.index') : '#' }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Users
            </a>
            <a href="{{ Route::has('admin.departments.index') ? route('admin.departments.index') : '#' }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.departments.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Departments
            </a>
            <a href="{{ Route::has('admin.categories.index') ? route('admin.categories.index') : '#' }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Categories
            </a>
            <a href="{{ Route::has('admin.reports.index') ? route('admin.reports.index') : '#' }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.reports.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Reports
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto p-8 bg-gray-50">
        @yield('admin-content')
    </div>
</div>
@endsection
