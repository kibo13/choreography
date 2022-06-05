<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\Title;
use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = Worker::orderBy('created_at', 'desc')->get();
        $titles  = Title::get();

        return view('admin.pages.workers.index', compact('workers', 'titles'));
    }

    public function create()
    {
        $roles  = Role::whereIn('slug', ['head', 'manager'])->get();
        $groups = Group::get();

        return view('admin.pages.workers.form', compact('roles', 'groups'));
    }

    public function store(Request $request)
    {
        $default_password = config('constants.password');

        $user = User::create([
            'username'      => @bk_rand('login', $request['last_name'], 5),
            'password'      => bcrypt($default_password),
            'role_id'       => $request['role_id'],
        ]);

        // TODO: head
        if ($user->role_id == 3) {
            $user->permissions()->attach([
                3, 4,
                11, 12,
                13, 14,
                17, 18,
                21, 22,
                23, 24,
                25, 26,
                27, 28,
                29, 30,
                31, 32,
                33,
                34, 35
            ]);
        }

        // TODO: manager
        if ($user->role_id == 4) {
            $user->permissions()->attach([
                15, 16,
                31
            ]);
        }

        $worker = Worker::create([
            'user_id'       => $user->id,
            'last_name'     => ucfirst($request['last_name']),
            'first_name'    => ucfirst($request['first_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'birthday'      => $request['birthday'],
            'age'           => @full_age($request['birthday']),
            'phone'         => $request['phone'],
            'email'         => $request['email'],
            'address'       => $request['address'],
        ]);

        if ($request->input('groups')) {
            $worker->groups()->attach($request->input('groups'));
        }

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.workers.index');
    }

    public function show(Worker $worker)
    {
        //
    }

    public function edit(Worker $worker)
    {
        $roles  = Role::whereIn('slug', ['head', 'manager'])->get();
        $groups = Group::get();

        return view('admin.pages.workers.form', compact('worker', 'groups', 'roles'));
    }

    public function update(Request $request, Worker $worker)
    {
        $worker->update([
            'last_name'     => $request['last_name'],
            'first_name'    => $request['first_name'],
            'middle_name'   => $request['middle_name'],
            'birthday'      => $request['birthday'],
            'age'           => @full_age($request['birthday']),
            'phone'         => $request['phone'],
            'email'         => $request['email'],
            'address'       => $request['address'],
        ]);

        $worker->groups()->detach();

        if ($request->input('groups')) {
            $worker->groups()->attach($request->input('groups'));
        }

        $worker->save();

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.workers.index');
    }

    public function destroy(Request $request, Worker $worker)
    {
        $worker->groups()->detach();
        $worker->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.workers.index');
    }
}
