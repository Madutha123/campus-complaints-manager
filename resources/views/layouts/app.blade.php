<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
    <!-- Top accent bar -->
    <div class="fixed top-0 left-0 right-0 z-50 h-0.5 bg-gradient-to-r from-indigo-500 via-indigo-400 to-indigo-600 dark:from-indigo-400 dark:via-indigo-500 dark:to-indigo-600"></div>

    <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 dark:border-zinc-700 bg-sidebar dark:bg-zinc-900 pt-0.5">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('home') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            @yield('sidebar')
        </flux:sidebar.nav>

        <flux:spacer />

        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials() ?? 'US'" icon-trailing="chevron-down" />
            <flux:menu>
                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                    {{ __('Settings') }}
                </flux:menu.item>
                <flux:menu.separator />
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                        {{ __('Log out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <flux:main class="flex-1 w-full bg-white dark:bg-zinc-800">
        <div class="animate-[fadeIn_0.3s_ease-out]">
            @yield('content')
        </div>
    </flux:main>

    @fluxScripts
    @stack('scripts')
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
