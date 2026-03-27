@extends('layouts.app')

@section('content')
<!-- Secondary Nav -->
<div class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('student.dashboard') }}" class="whitespace-nowrap px-1 py-4 text-sm font-medium border-b-2 transition {{ request()->routeIs('student.dashboard') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Dashboard
            </a>
            <a href="{{ Route::has('student.complaints.index') ? route('student.complaints.index') : '#' }}" class="whitespace-nowrap px-1 py-4 text-sm font-medium border-b-2 transition {{ request()->routeIs('student.complaints.index') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                My Complaints
            </a>
            <a href="{{ Route::has('student.complaints.create') ? route('student.complaints.create') : '#' }}" class="whitespace-nowrap px-1 py-4 text-sm font-medium border-b-2 transition {{ request()->routeIs('student.complaints.create') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Submit Complaint
            </a>
            <a href="{{ Route::has('student.notifications.index') ? route('student.notifications.index') : '#' }}" class="whitespace-nowrap px-1 py-4 text-sm font-medium border-b-2 transition {{ request()->routeIs('student.notifications.*') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Notifications
            </a>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="flex-1 bg-gray-50 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('student-content')
    </div>
</div>
@endsection
