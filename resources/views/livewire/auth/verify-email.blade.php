<x-layouts::auth :title="__('Email verification')">
    <div class="flex flex-col gap-6">
        <div class="space-y-2 text-center">
            <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 mb-4">
                <flux:icon.envelope class="size-7 text-indigo-600 dark:text-indigo-400" />
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Verify your email</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Please verify your email address by clicking the link we just emailed to you.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="rounded-xl border border-emerald-200 dark:border-emerald-500/20 bg-emerald-50 dark:bg-emerald-500/10 p-4 text-sm font-medium text-emerald-800 dark:text-emerald-200 text-center">
                <flux:icon.check-circle class="size-4 inline-block mr-1.5 -mt-0.5" />
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="flex flex-col items-center gap-4 pt-2">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Resend verification email') }}
                </flux:button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button variant="ghost" type="submit" class="text-sm cursor-pointer" data-test="logout-button">
                    {{ __('Log out') }}
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::auth>
