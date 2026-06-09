@extends('layouts.app')

@section('sidebar')
<flux:sidebar.group :heading="__('Admin Portal')">
    <flux:sidebar.item icon="layout-grid" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
        Dashboard
    </flux:sidebar.item>
    <flux:sidebar.item icon="inbox-arrow-down" :href="Route::has('admin.complaints.index') ? route('admin.complaints.index') : '#'" :current="request()->routeIs('admin.complaints.*')" wire:navigate>
        Complaints
    </flux:sidebar.item>
    <flux:sidebar.item icon="users" :href="Route::has('admin.users.index') ? route('admin.users.index') : '#'" :current="request()->routeIs('admin.users.*')" wire:navigate>
        Users
    </flux:sidebar.item>
    <flux:sidebar.item icon="building-office-2" :href="Route::has('admin.departments.index') ? route('admin.departments.index') : '#'" :current="request()->routeIs('admin.departments.*')" wire:navigate>
        Departments
    </flux:sidebar.item>
    <flux:sidebar.item icon="tag" :href="Route::has('admin.categories.index') ? route('admin.categories.index') : '#'" :current="request()->routeIs('admin.categories.*')" wire:navigate>
        Categories
    </flux:sidebar.item>
    <flux:sidebar.item icon="chart-bar" :href="Route::has('admin.reports.index') ? route('admin.reports.index') : '#'" :current="request()->routeIs('admin.reports.*')" wire:navigate>
        Reports
    </flux:sidebar.item>
</flux:sidebar.group>
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 w-full mx-auto max-w-7xl">
    @yield('admin-content')
</div>
@endsection
