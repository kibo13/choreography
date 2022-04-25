<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', 4)->get();

        return view('admin.pages.customers.index', compact('users'));
    }

    public function create()
    {
        $docs = config('constants.docs');

        return view('admin.pages.customers.form', compact('docs'));
    }

    public function store(Request $request)
    {
        $default_password = config('constants.password');

        unset($request['address_doc']);

        if ($request->has('address_doc')) {
            $file       = $request->file('address_doc');
            $file_name  = $file->getClientOriginalName();
            $file_path  = $file->store('addresses');
        }

        $user = User::create([
            'username'      => @bk_rand('login', $request['last_name'], 5),
            'password'      => bcrypt($default_password),
            'role_id'       => 4,
            'first_name'    => ucfirst($request['first_name']),
            'last_name'     => ucfirst($request['last_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'doc_type'      => $request['doc_type'],
            'doc_num'       => $request['doc_num'],
            'doc_date'      => $request['doc_date'],
            'birthday'      => $request['birthday'],
            'age'           => @full_age($request['birthday']),
            'address_doc'   => $file_path ?? null ? $file_path : null,
            'address_note'  => $file_name ?? null ? $file_name : null,
            'address_fact'  => ucfirst($request['address_fact']),
            'activity'      => ucfirst($request['activity']),
            'phone'         => $request['phone'],
            'email'         => $request['email'],
        ]);

        // TODO: keep track sections
        $user->permissions()->attach([1, 2, 9, 10]);

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.customers.index');
    }

    public function show(User $user)
    {
        return view('admin.pages.customers.show', compact('user'));
    }

    public function edit(User $user)
    {
        $docs = config('constants.docs');

        return view('admin.pages.customers.form', compact('user', 'docs'));
    }

    public function update(Request $request, User $user)
    {
        unset($request['address_doc']);

        if ($request->has('address_doc')) {
            Storage::delete($user->address_doc);
            $file       = $request->file('address_doc');
            $file_name  = $file->getClientOriginalName();
            $file_path  = $file->store('addresses');
        }

        $user->update([
            'first_name'    => ucfirst($request['first_name']),
            'last_name'     => ucfirst($request['last_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'doc_type'      => $request['doc_type'],
            'doc_num'       => $request['doc_num'],
            'doc_date'      => $request['doc_date'],
            'birthday'      => $request['birthday'],
            'age'           => @full_age($request['birthday']),
            'address_doc'   => $file_path ?? null ? $file_path : null,
            'address_note'  => $file_name ?? null ? $file_name : null,
            'address_fact'  => ucfirst($request['address_fact']),
            'activity'      => ucfirst($request['activity']),
            'phone'         => $request['phone'],
            'email'         => $request['email'],
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.customers.index');
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        Storage::delete($user->address_doc);

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.customers.index');
    }
}
