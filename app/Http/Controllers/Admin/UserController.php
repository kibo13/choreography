<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // prod
        // $users = User::whereIn('role_id', [2, 3])->get();
        $sections = @sections();

        // test
        $users = User::where('username', '!=', 'kibo')->get();

        return view(
            'admin.pages.users.index',
            compact('users', 'sections')
        );
    }

    public function create()
    {
        // prod
        // $roles       = Role::whereIn('slug', ['head', 'manager'])->get();
        $permissions = Permission::get();
        $sections    = @sections();

        // test
        $roles = Role::get();

        return view(
            'admin.pages.users.form',
            compact('roles', 'permissions', 'sections')
        );
    }

    public function store(Request $request)
    {
        $default_password = config('constants.password');

        $user = User::create([
            'first_name'    => ucfirst($request['first_name']),
            'last_name'     => ucfirst($request['last_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'birthday'      => $request['birthday'],
            'age'           => @full_age($request['birthday']),
            'phone'         => $request['phone'],
            'email'         => $request['email'],
            'address_fact'  => $request['address_fact'],
            'username'      => @bk_rand('login', $request['last_name'], 5),
            'password'      => bcrypt($default_password),
            'role_id'       => $request['role_id']
        ]);

        if ($request->input('permissions')) :
            $user->permissions()->attach($request->input('permissions'));
        endif;

        $request->session()->flash('success', __('record.added'));
        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        // prod
        // $roles       = Role::whereIn('slug', ['head', 'manager'])->get();
        $permissions = Permission::get();
        $sections    = @sections();

        // test
        $roles = Role::get();

        return view(
            'admin.pages.users.form',
            compact('user', 'roles', 'permissions', 'sections')
        );
    }

    public function update(Request $request, User $user)
    {
        $user->first_name   = $request['first_name'];
        $user->last_name    = $request['last_name'];
        $user->middle_name  = $request['middle_name'];
        $user->birthday     = $request['birthday'];
        $user->age          = @full_age($request['birthday']);
        $user->phone        = $request['phone'];
        $user->email        = $request['email'];
        $user->address_fact = $request['address_fact'];
        $user->role_id      = $request['role_id'];

        $user->permissions()->detach();
        if ($request->input('permissions')) :
            $user->permissions()->attach($request->input('permissions'));
        endif;

        $user->save();

        $request->session()->flash('success', __('record.updated'));
        return redirect()->route('admin.users.index');
    }

    public function destroy(Request $request, User $user)
    {
        $user->permissions()->detach();
        $user->delete();

        $request->session()->flash('success', __('record.deleted'));
        return redirect()->route('admin.users.index');
    }
}
