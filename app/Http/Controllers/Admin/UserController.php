<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        return response('Admin Users List');
    }

    public function create(): Response
    {
        return response('Admin Create User');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.users.index');
    }

    public function show(User $user): Response
    {
        return response('Admin User #'.$user->id);
    }

    public function edit(User $user): Response
    {
        return response('Admin Edit User #'.$user->id);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user): RedirectResponse
    {
        return redirect()->route('admin.users.index');
    }
}
