<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6" x-data="{ role: '{{ old('role', 'student') }}' }">
        <div class="space-y-2 animate-[fadeIn_0.5s_ease-out_both]">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Create an account</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Register as a student or staff member.</p>
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

        <form method="POST" action="{{ url('/register') }}" class="flex flex-col gap-5">
            @csrf

            <div class="animate-[fadeIn_0.5s_ease-out_0.05s_both]">
                <flux:input
                    name="name"
                    :label="__('Full name')"
                    :value="old('name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="John Doe"
                />
            </div>

            <div class="animate-[fadeIn_0.5s_ease-out_0.1s_both]">
                <flux:input
                    name="email"
                    :label="__('Email address')"
                    :value="old('email')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="you@campus.edu"
                />
            </div>

            <div class="grid gap-5 sm:grid-cols-2 animate-[fadeIn_0.5s_ease-out_0.15s_both]">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Min. 8 characters"
                    viewable
                />

                <flux:input
                    name="password_confirmation"
                    :label="__('Confirm password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Repeat password"
                    viewable
                />
            </div>

            <div class="animate-[fadeIn_0.5s_ease-out_0.2s_both]">
                <flux:select name="role" :label="__('Role')" x-model="role" required>
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                </flux:select>
            </div>

            <div x-show="role === 'student'" 
                 x-cloak 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="animate-[fadeIn_0.5s_ease-out_0.25s_both]">
                <flux:input
                    name="student_id"
                    :label="__('Student ID')"
                    :value="old('student_id')"
                    type="text"
                    placeholder="e.g. STU-2024-0001"
                />
            </div>

            <div x-show="role === 'staff'" 
                 x-cloak 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="animate-[fadeIn_0.5s_ease-out_0.25s_both]">
                <flux:input
                    name="employee_id"
                    :label="__('Employee ID')"
                    :value="old('employee_id')"
                    type="text"
                    placeholder="e.g. EMP-2024-0001"
                />
            </div>

            <div class="animate-[fadeIn_0.5s_ease-out_0.3s_both]">
                <flux:button variant="primary" type="submit" class="w-full">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400 animate-[fadeIn_0.5s_ease-out_0.35s_both]">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Sign in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
