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
                    <!-- Campus Backdrop Image -->
                    <img src="{{ asset('images/campus_architecture.png') }}" alt="Campus Backdrop" class="absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-luminosity">
                    <!-- Premium Purple-Zinc Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-950/95 via-zinc-950/90 to-zinc-900/90"></div>
                    <!-- Top-down shadow gradient for header readability -->
                    <div class="absolute top-0 left-0 right-0 h-1/3 bg-gradient-to-b from-zinc-950/80 to-transparent"></div>
                    <!-- Radial Grid Pattern Overlay -->
                    <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 32px 32px;"></div>
                    <!-- Bottom Highlight -->
                    <div class="absolute bottom-0 left-0 right-0 h-2/3 bg-gradient-to-t from-indigo-950/30 to-transparent"></div>
                </div>

                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-xl font-bold tracking-tight text-white hover:text-zinc-200 transition" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/20 mr-3 border border-indigo-400/20 backdrop-blur-sm">
                        <x-app-logo-icon class="h-6 w-6 text-indigo-400" />
                    </span>
                    {{ config('app.name', 'CampusTrack') }}
                </a>

                <div class="relative z-30 mt-auto space-y-6">
                    <div class="space-y-2">
                        <h2 class="text-3xl font-extrabold tracking-tight drop-shadow-2xl text-white">
                            Your voice. <br><span class="text-indigo-400 bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">Our campus.</span>
                        </h2>
                        <p class="text-md text-white/80 max-w-md drop-shadow-lg leading-relaxed">
                            Empowering students and staff to build a better community. Report maintenance issues, academic grievances, or general complaints and track real-time resolution progress.
                        </p>
                    </div>

                    <!-- Floating Asymmetric Pills (Horizontal Row) -->
                    <div class="flex flex-row flex-wrap gap-6">
                        <!-- Pill 1: Resolutions -->
                        <div class="flex items-center gap-3 w-fit bg-white/5 px-4 py-5 rounded-xl border border-white/10 backdrop-blur-xl shadow-lg transform hover:scale-[1.03] transition duration-300">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400">
                                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white leading-none">98.4%</p>
                                <span class="text-[10px] text-zinc-400 font-medium">Resolved Issues</span>
                            </div>
                            <span class="relative flex h-1.5 w-1.5 ml-1">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                            </span>
                        </div>

                        <!-- Pill 2: Response -->
                        <div class="flex items-center gap-3 w-fit bg-white/5 px-4 py-2.5 rounded-xl border border-white/10 backdrop-blur-xl shadow-lg transform hover:scale-[1.03] transition duration-300">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400">
                                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white leading-none">&lt; 24h</p>
                                <span class="text-[10px] text-zinc-400 font-medium">Average Response</span>
                            </div>
                        </div>

                        <!-- Pill 3: Active Staff -->
                        <div class="flex items-center gap-3 w-fit bg-white/5 px-4 py-2.5 rounded-xl border border-white/10 backdrop-blur-xl shadow-lg transform hover:scale-[1.03] transition duration-300">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400">
                                <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20M3.75 20.172v-.108c0-2.39 1.314-4.57 3.447-5.617m0 0l.236-.113m-.236.112a11.408 11.408 0 010-12.753m0 12.753a11.36 11.36 0 00-2.022-2.112m.758-3.199a3.75 3.75 0 100-7.5m0 7.5a3.75 3.75 0 010-7.5m0 7.5L5.25 7.5m9-3.037a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white leading-none">45+ Active</p>
                                <span class="text-[10px] text-zinc-400 font-medium">Resolving Staff</span>
                            </div>
                        </div>
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
