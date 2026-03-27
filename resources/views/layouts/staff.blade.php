@extends('layouts.app')

@section('content')
<div class="flex flex-1 overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0">
        <nav class="p-4 space-y-1">
            <a href="{{ route('staff.dashboard') }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('staff.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Dashboard
            </a>
            <a href="{{ Route::has('staff.complaints.index') ? route('staff.complaints.index') : '#' }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('staff.complaints.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Assigned Complaints
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto p-8 bg-gray-50">
        @yield('staff-content')
    </div>
</div>
@endsection
