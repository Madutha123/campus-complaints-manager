<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="w-full max-w-xl bg-white rounded-2xl shadow-xl p-8" x-data="{ role: '{{ old('role', 'student') }}' }">
        <h1 class="text-2xl font-bold text-gray-900">Create Account</h1>
        <p class="mt-1 text-sm text-gray-600">Register as a student or staff member.</p>

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}" class="mt-6 grid gap-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                >
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                    >
                </div>

                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input
                        id="password_confirm"
                        name="password_confirmation"
                        type="password"
                        required
                        class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                    >
                </div>
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select
                    id="role"
                    name="role"
                    x-model="role"
                    required
                    class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                >
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                </select>
            </div>

            <div x-show="role === 'student'" x-cloak>
                <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                <input
                    id="student_id"
                    name="student_id"
                    type="text"
                    value="{{ old('student_id') }}"
                    class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                >
            </div>

            <div x-show="role === 'staff'" x-cloak>
                <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
                <input
                    id="employee_id"
                    name="employee_id"
                    type="text"
                    value="{{ old('employee_id') }}"
                    class="mt-1 w-full rounded-lg border border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                >
            </div>

            <button
                type="submit"
                class="mt-2 w-full rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-black"
            >
                Register
            </button>
        </form>
    </div>
</body>
</html>
