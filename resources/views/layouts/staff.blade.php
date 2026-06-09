@extends('layouts.app')

@section('sidebar')
<flux:sidebar.group :heading="__('Staff Portal')">
    <flux:sidebar.item icon="layout-grid" :href="route('staff.dashboard')" :current="request()->routeIs('staff.dashboard')" wire:navigate>
        Dashboard
    </flux:sidebar.item>
    <flux:sidebar.item icon="inbox-arrow-down" :href="Route::has('staff.complaints.index') ? route('staff.complaints.index') : '#'" :current="request()->routeIs('staff.complaints.*')" wire:navigate>
        Assigned Complaints
    </flux:sidebar.item>
</flux:sidebar.group>
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 w-full mx-auto max-w-6xl">
    @yield('staff-content')
</div>
@endsection
