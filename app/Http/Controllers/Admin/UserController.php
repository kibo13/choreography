<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $is_kibo        = Auth::user()->role_id;
        $users          = $is_kibo == 1 ? User::get() : User::where('role_id', '>', 1)->get();
        $sections       = @sections();

        return view(
            'admin.pages.users.index',
            compact('users','sections')
        );
    }

    public function create()
    {
        $sections       = @sections();
        $roles          = Role::get();
        $permissions    = Permission::get();

        return view(
            'admin.pages.users.form',
            compact('sections', 'roles', 'permissions')
        );
    }

    public function store(Request $request)
    {
        $default_password = config('constants.password');

        $user = User::create([
            'username'      => $request['username'],
            'password'      => bcrypt($default_password),
            'role_id'       => $request['role_id']
        ]);

        if ($request->input('permissions')) :
            $user->permissions()->attach($request->input('permissions'));
        endif;

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $sections       = @sections();
        $roles          = Role::get();
        $permissions    = Permission::get();

        return view(
            'admin.pages.users.form',
            compact('user', 'sections', 'roles', 'permissions')
        );
    }

    public function update(Request $request, User $user)
    {
        $user->update([
            'username'      => $request['username'],
            'role_id'       => $request['role_id']
        ]);

        $user->permissions()->detach();
        if ($request->input('permissions')) :
            $user->permissions()->attach($request->input('permissions'));
        endif;

        $user->save();

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.users.index');
    }

    public function destroy(Request $request, User $user)
    {
        $user->permissions()->detach();
        $user->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.users.index');
    }
}
