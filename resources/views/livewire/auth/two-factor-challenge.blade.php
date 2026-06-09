<x-layouts::auth :title="__('Two-factor authentication')">
    <div class="flex flex-col gap-6">
        <div
            class="relative w-full h-auto"
            x-cloak
            x-data="{
                showRecoveryInput: @js($errors->has('recovery_code')),
                code: '',
                recovery_code: '',
                toggleInput() {
                    this.showRecoveryInput = !this.showRecoveryInput;
                    this.code = '';
                    this.recovery_code = '';
                    $dispatch('clear-2fa-auth-code');
                    $nextTick(() => {
                        this.showRecoveryInput
                            ? this.$refs.recovery_code?.focus()
                            : $dispatch('focus-2fa-auth-code');
                    });
                },
            }"
        >
            <div x-show="!showRecoveryInput" class="space-y-2 text-center">
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Authentication code</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Enter the code from your authenticator app.</p>
            </div>

            <div x-show="showRecoveryInput" class="space-y-2 text-center">
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Recovery code</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Enter one of your emergency recovery codes.</p>
            </div>

            <form method="POST" action="{{ route('two-factor.login.store') }}" class="mt-2">
                @csrf

                <div class="space-y-5 text-center">
                    <div x-show="!showRecoveryInput">
                        <div class="flex items-center justify-center my-6">
                            <flux:otp
                                x-model="code"
                                length="6"
                                name="code"
                                label="OTP Code"
                                label:sr-only
                                class="mx-auto"
                             />
                        </div>
                    </div>

                    <div x-show="showRecoveryInput">
                        <div class="my-5">
                            <flux:input
                                type="text"
                                name="recovery_code"
                                x-ref="recovery_code"
                                x-bind:required="showRecoveryInput"
                                autocomplete="one-time-code"
                                x-model="recovery_code"
                                placeholder="XXXXX-XXXXX"
                            />
                        </div>

                        @error('recovery_code')
                            <flux:text color="red">
                                {{ $message }}
                            </flux:text>
                        @enderror
                    </div>

                    <flux:button variant="primary" type="submit" class="w-full">
                        {{ __('Continue') }}
                    </flux:button>
                </div>

                <div class="mt-5 text-sm text-center text-zinc-500 dark:text-zinc-400">
                    <span>{{ __('Or') }}</span>
                    <button type="button" class="inline font-medium text-indigo-600 dark:text-indigo-400 underline underline-offset-2 hover:text-indigo-800 dark:hover:text-indigo-300 transition ml-1" @click="toggleInput()">
                        <span x-show="!showRecoveryInput">{{ __('use a recovery code') }}</span>
                        <span x-show="showRecoveryInput">{{ __('use an authentication code') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::auth>
