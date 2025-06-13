<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\Role;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage-users');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::with('roles')->paginate(15);
    $roles = Role::all();
    return view('admin.users', compact('users', 'roles'));
}

public function updateRoles(Request $request, User $user)
{
    $validated = $request->validate([
        'roles' => 'array',
        'roles.*' => 'exists:roles,id',
    ]);

    $user->roles()->sync($validated['roles']);

    return redirect()->route('admin.users')
        ->with('success', 'User roles updated successfully!');
}

    public function groups()
    {
        $groups = Group::withCount('songs')->paginate(10);
        return view('admin.groups', compact('groups'));
    }

    public function events()
    {
        $events = Event::with('creator')->paginate(10);
        return view('admin.events', compact('events'));
    }
}
