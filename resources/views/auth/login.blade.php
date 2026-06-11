<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <div class="space-y-2 animate-[fadeIn_0.5s_ease-out_both]">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Welcome back</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Enter your credentials to access your account.</p>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-red-200 dark:border-red-500/20 bg-red-50 dark:bg-red-500/10 p-4 animate-[fadeIn_0.5s_ease-out_both]">
                <ul class="list-disc pl-5 space-y-1 text-sm text-red-700 dark:text-red-400">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="flex flex-col gap-5">
            @csrf

            <div class="animate-[fadeIn_0.5s_ease-out_0.1s_both]">
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    :value="old('email')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="you@campus.edu"
                />
            </div>

            <div class="relative animate-[fadeIn_0.5s_ease-out_0.15s_both]">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Enter your password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <div class="animate-[fadeIn_0.5s_ease-out_0.2s_both]">
                <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />
            </div>

            <div class="animate-[fadeIn_0.5s_ease-out_0.25s_both]">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400 animate-[fadeIn_0.5s_ease-out_0.3s_both]">
                <span>{{ __("Don't have an account?") }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts::auth>
