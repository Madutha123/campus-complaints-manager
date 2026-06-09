@extends('layouts.app')

@section('sidebar')
<flux:sidebar.group :heading="__('Student Portal')">
    <flux:sidebar.item icon="layout-grid" :href="route('student.dashboard')" :current="request()->routeIs('student.dashboard')" wire:navigate>
        Dashboard
    </flux:sidebar.item>
    <flux:sidebar.item icon="inbox-arrow-down" :href="Route::has('student.complaints.index') ? route('student.complaints.index') : '#'" :current="request()->routeIs('student.complaints.*')" wire:navigate>
        My Complaints
    </flux:sidebar.item>
    <flux:sidebar.item icon="plus-circle" :href="Route::has('student.complaints.create') ? route('student.complaints.create') : '#'" :current="request()->routeIs('student.complaints.create')" wire:navigate>
        Submit Complaint
    </flux:sidebar.item>
</flux:sidebar.group>
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 w-full mx-auto max-w-5xl">
    @yield('student-content')
</div>
@endsection
