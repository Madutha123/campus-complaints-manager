<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-zinc-950 dark:to-zinc-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <!-- Left Panel - Decorative -->
            <div class="relative hidden h-full flex-col p-10 lg:flex dark:border-e dark:border-zinc-800/50">
                <div class="absolute inset-0 bg-zinc-950">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-950/40 via-zinc-950 to-zinc-900"></div>
                    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 32px 32px;"></div>
                    <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-indigo-950/20 to-transparent"></div>
                </div>

                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-xl font-bold tracking-tight text-white hover:text-zinc-200 transition" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/20 mr-3 border border-indigo-400/20 backdrop-blur-sm">
                        <x-app-logo-icon class="h-6 w-6 text-indigo-400" />
                    </span>
                    {{ config('app.name', 'CampusTrack') }}
                </a>

                @php
                    try {
                        $quoteText = Illuminate\Foundation\Inspiring::quotes()->random();
                        [$message, $author] = str($quoteText)->contains('-') ? str($quoteText)->explode('-') : [$quoteText, ''];
                    } catch (\Exception $e) {
                        $message = "Quality is not an act, it is a habit.";
                        $author = "Aristotle";
                    }
                @endphp

                <div class="relative z-20 mt-auto">
                    <div class="relative bg-zinc-900/60 p-6 rounded-2xl border border-zinc-800/60 backdrop-blur-xl shadow-2xl">
                        <div class="absolute -top-px left-6 right-6 h-px bg-gradient-to-r from-transparent via-indigo-400/40 to-transparent"></div>
                        <blockquote class="space-y-3">
                            <flux:heading size="lg" class="text-white font-medium leading-relaxed">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                            <footer class="text-zinc-400 font-medium tracking-wide text-sm flex items-center gap-2">
                                <div class="w-4 h-px bg-zinc-600"></div>
                                {{ trim($author) }}
                            </footer>
                        </blockquote>
                    </div>
                </div>

                <!-- Brand footer -->
                <div class="relative z-20 mt-8 text-xs text-zinc-600">
                    &copy; {{ date('Y') }} {{ config('app.name', 'CampusTrack') }}. All rights reserved.
                </div>
            </div>

            <!-- Right Panel - Auth Form -->
            <div class="w-full lg:p-8 bg-white dark:bg-zinc-900 h-full flex items-center">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[400px]">
                    <!-- Mobile Logo -->
                    <div class="flex flex-col items-center gap-3 lg:hidden animate-[fadeIn_0.5s_ease-out]">
                        <a href="{{ route('home') }}" class="flex flex-col items-center gap-3" wire:navigate>
                            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-500/20">
                                <x-app-logo-icon class="size-7 text-indigo-600 dark:text-indigo-400" />
                            </span>
                            <span class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ config('app.name', 'CampusTrack') }}</span>
                        </a>
                    </div>

                    <div class="animate-[fadeIn_0.5s_ease-out_0.1s_both]">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(8px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </body>
</html>
