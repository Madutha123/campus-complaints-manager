<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6" x-data="{ role: '{{ old('role', 'student') }}' }">
        <div class="space-y-2">
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Create an account</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Register as a student or staff member.</p>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-red-200 dark:border-red-500/20 bg-red-50 dark:bg-red-500/10 p-4">
                <ul class="list-disc pl-5 space-y-1 text-sm text-red-700 dark:text-red-400">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}" class="flex flex-col gap-5">
            @csrf

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

            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="you@campus.edu"
            />

            <div class="grid gap-5 sm:grid-cols-2">
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

            <div>
                <flux:select name="role" :label="__('Role')" x-model="role" required>
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                </flux:select>
            </div>

            <div x-show="role === 'student'" x-cloak>
                <flux:input
                    name="student_id"
                    :label="__('Student ID')"
                    :value="old('student_id')"
                    type="text"
                    placeholder="e.g. STU-2024-0001"
                />
            </div>

            <div x-show="role === 'staff'" x-cloak>
                <flux:input
                    name="employee_id"
                    :label="__('Employee ID')"
                    :value="old('employee_id')"
                    type="text"
                    placeholder="e.g. EMP-2024-0001"
                />
            </div>

            <flux:button variant="primary" type="submit" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </form>

        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Sign in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
