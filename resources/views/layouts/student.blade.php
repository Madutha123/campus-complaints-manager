@extends('layouts.app')

@section('content')
<div class="flex flex-1 overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 shrink-0 border-r border-gray-200 bg-white">
        <nav class="p-4 space-y-1">
            <a href="{{ route('student.dashboard') }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('student.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Dashboard
            </a>
            <a href="{{ Route::has('student.complaints.index') ? route('student.complaints.index') : '#' }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('student.complaints.index') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                My Complaints
            </a>
            <a href="{{ Route::has('student.complaints.create') ? route('student.complaints.create') : '#' }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('student.complaints.create') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Submit Complaint
            </a>
            <a href="{{ Route::has('student.notifications.index') ? route('student.notifications.index') : '#' }}" class="block px-4 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('student.notifications.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                Notifications
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto p-8 bg-gray-50">
        @yield('student-content')
    </div>
</div>
@endsection
