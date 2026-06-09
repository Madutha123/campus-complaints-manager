<x-layouts::auth :title="__('Confirm password')">
    <div class="flex flex-col gap-6">
        <div class="space-y-2">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Confirm your password</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">This is a secure area. Please confirm your password before continuing.</p>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Enter your password')"
                viewable
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                <flux:icon.shield-exclamation class="size-4" />
                {{ __('Confirm') }}
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
