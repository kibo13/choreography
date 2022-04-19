<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', '!=', 1)->get();

        return view('admin.pages.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('slug', '!=', 'admin')->get();
        $permissions = Permission::get();

        return view('admin.pages.users.form', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name'  => $request['last_name'],
            'username'   => $request['username'],
            'password'   => bcrypt($request['password']),
            'role_id'    => $request['role_id'],
        ]);

        if ($request->input('permissions')) :
            $user->permissions()->attach($request->input('permissions'));
        endif;

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        return view('admin.pages.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::where('slug', '!=', 'admin')->get();
        $permissions = Permission::get();

        return view('admin.pages.users.form', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->first_name   = $request['first_name'];
        $user->last_name    = $request['last_name'];
        $user->username     = $request['username'];
        $user->role_id      = $request['role_id'];

        if (!is_null($request['password'])) {
            $user->password = bcrypt($request['password']);
        }

        $user->permissions()->detach();
        if ($request->input('permissions')) :
            $user->permissions()->attach($request->input('permissions'));
        endif;

        $user->save();

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        $user->permissions()->detach();
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
