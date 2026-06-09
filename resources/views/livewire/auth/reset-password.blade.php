<x-layouts::auth :title="__('Reset password')">
    <div class="flex flex-col gap-6">
        <div class="space-y-2">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Reset password</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Please enter your new password below.</p>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf

            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <flux:input
                name="email"
                value="{{ request('email') }}"
                :label="__('Email')"
                type="email"
                required
                autocomplete="email"
            />

            <flux:input
                name="password"
                :label="__('New password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Min. 8 characters')"
                viewable
            />

            <flux:input
                name="password_confirmation"
                :label="__('Confirm new password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Repeat password')"
                viewable
            />

            <flux:button type="submit" variant="primary" class="w-full" data-test="reset-password-button">
                {{ __('Reset password') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Remember your password?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
