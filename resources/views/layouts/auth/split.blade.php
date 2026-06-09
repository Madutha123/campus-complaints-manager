<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-neutral-800">
                <div class="absolute inset-0 bg-zinc-900">
                    <!-- Subtle background pattern or gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-zinc-900 via-zinc-800 to-black"></div>
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 24px 24px;"></div>
                </div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-xl font-bold tracking-tight text-white hover:text-zinc-200 transition" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-md bg-white/10 mr-3 border border-white/20 backdrop-blur-sm">
                        <x-app-logo-icon class="h-6 w-6 text-white" />
                    </span>
                    {{ config('app.name', 'CampusTrack') }}
                </a>

                @php
                    // Fallback if quote generator breaks
                    try {
                        $quoteText = Illuminate\Foundation\Inspiring::quotes()->random();
                        [$message, $author] = str($quoteText)->contains('-') ? str($quoteText)->explode('-') : [$quoteText, ''];
                    } catch (\Exception $e) {
                        $message = "Quality is not an act, it is a habit.";
                        $author = "Aristotle";
                    }
                @endphp

                <div class="relative z-20 mt-auto bg-black/20 p-6 rounded-2xl border border-white/10 backdrop-blur-md">
                    <blockquote class="space-y-3">
                        <flux:heading size="lg" class="text-white font-medium leading-relaxed">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                        <footer class="text-zinc-300 font-medium tracking-wide text-sm flex items-center gap-2">
                            <div class="w-4 h-0.5 bg-zinc-500 rounded-full"></div>
                            {{ trim($author) }}
                        </footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8 bg-white dark:bg-zinc-900 h-full flex items-center">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[380px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-3 font-medium lg:hidden" wire:navigate>
                        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                            <x-app-logo-icon class="size-7 text-zinc-900 dark:text-white" />
                        </span>
                        <span class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ config('app.name', 'CampusTrack') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
