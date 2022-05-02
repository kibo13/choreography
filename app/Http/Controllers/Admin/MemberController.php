<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::get();

        return view('admin.pages.members.index', compact('members'));
    }

    public function create()
    {
        $docs = config('constants.docs');

        return view('admin.pages.members.form', compact('docs'));
    }

    public function store(Request $request)
    {
        $default_password = config('constants.password');

        unset($request['address_doc']);

        if ($request->has('address_doc')) {
            $file       = $request->file('address_doc');
            $file_name  = $file->getClientOriginalName();
            $file_path  = $file->store('members');
        }

        $user = User::create([
            'username'      => @bk_rand('login', $request['last_name'], 5),
            'password'      => bcrypt($default_password),
            'role_id'       => 5,
        ]);

        // TODO: keep track sections
//        $user->permissions()->attach([1, 2, 9, 10]);

        Member::create([
            'user_id'       => $user->id,
            'last_name'     => ucfirst($request['last_name']),
            'first_name'    => ucfirst($request['first_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'doc_type'      => $request['doc_type'],
            'doc_num'       => $request['doc_num'],
            'doc_date'      => $request['doc_date'],
            'birthday'      => $request['birthday'],
            'age'           => @full_age($request['birthday']),
            'address_doc'   => $file_path ?? null ? $file_path : null,
            'address_note'  => $file_name ?? null ? $file_name : null,
            'address_fact'  => $request['address_fact'],
            'activity'      => $request['activity'],
            'phone'         => $request['phone'],
            'email'         => $request['email'],
        ]);

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.members.index');
    }

    public function show(Member $member)
    {
        return view('admin.pages.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $docs = config('constants.docs');

        return view('admin.pages.members.form', compact('member', 'docs'));
    }

    public function update(Request $request, Member $member)
    {
        unset($request['address_doc']);

        if ($request->has('address_doc')) {
            Storage::delete($member->address_doc);
            $file       = $request->file('address_doc');
            $file_name  = $file->getClientOriginalName();
            $file_path  = $file->store('members');
        }

        $member->update([
            'last_name'     => ucfirst($request['last_name']),
            'first_name'    => ucfirst($request['first_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'doc_type'      => $request['doc_type'],
            'doc_num'       => $request['doc_num'],
            'doc_date'      => $request['doc_date'],
            'birthday'      => $request['birthday'],
            'age'           => @full_age($request['birthday']),
            'address_doc'   => $file_path ?? null ? $file_path : null,
            'address_note'  => $file_name ?? null ? $file_name : null,
            'address_fact'  => $request['address_fact'],
            'activity'      => $request['activity'],
            'phone'         => $request['phone'],
            'email'         => $request['email'],
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.members.index');
    }

    public function destroy(Request $request, Member $member)
    {
        $member->delete();
        Storage::delete($member->address_doc);

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.members.index');
    }
}
