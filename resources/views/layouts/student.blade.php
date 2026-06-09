@extends('layouts.app')

@section('sidebar')
<flux:sidebar.group :heading="__('Student Portal')">
    <flux:sidebar.item icon="layout-grid" :href="route('student.dashboard')" :current="request()->routeIs('student.dashboard')" wire:navigate>
        Dashboard
    </flux:sidebar.item>
    <flux:sidebar.item icon="ticket" :href="Route::has('student.complaints.index') ? route('student.complaints.index') : '#'" :current="request()->routeIs('student.complaints.index')" wire:navigate>
        My Complaints
    </flux:sidebar.item>
    <flux:sidebar.item icon="plus-circle" :href="Route::has('student.complaints.create') ? route('student.complaints.create') : '#'" :current="request()->routeIs('student.complaints.create')" wire:navigate>
        Submit Complaint
    </flux:sidebar.item>
    <flux:sidebar.item icon="bell" :href="Route::has('student.notifications.index') ? route('student.notifications.index') : '#'" :current="request()->routeIs('student.notifications.*')" wire:navigate>
        Notifications
    </flux:sidebar.item>
</flux:sidebar.group>
@endsection

@section('content')
<div class="px-6 py-6 w-full mx-auto max-w-5xl">
    @yield('student-content')
</div>
@endsection
