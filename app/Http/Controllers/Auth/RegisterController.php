<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['student', 'staff'])],
            'student_id' => ['nullable', 'string', 'max:255', 'required_if:role,student'],
            'employee_id' => ['nullable', 'string', 'max:255', 'required_if:role,staff'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'student_id' => $validated['role'] === 'student' ? $validated['student_id'] : null,
            'employee_id' => $validated['role'] === 'staff' ? $validated['employee_id'] : null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect($this->dashboardPathByRole($validated['role']));
    }

    private function dashboardPathByRole(string $role): string
    {
        return match ($role) {
            'staff' => '/staff/dashboard',
            default => '/student/dashboard',
        };
    }
}
