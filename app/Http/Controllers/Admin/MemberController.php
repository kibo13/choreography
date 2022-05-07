<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Member;
use App\Models\User;
use App\Models\Doc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    private function worker()
    {
        return Auth::user()->worker;
    }

    public function index(Request $request)
    {
        switch (Auth::user()->role_id) {
            case 1:
            case 2:
                $groups  = [];
                $members = Member::get();
                break;

            case 3:
                $groups  = $this->worker()->groups;
                $members = [];
                break;

            case 4:
            case 5:
                $groups  = [];
                $members = [];
                $request->session()->flash('warning', __('_dialog.group_null'));
                break;
        }

        return view('admin.pages.members.index', compact('groups', 'members'));
    }

    public function create(Request $request)
    {
        if (is_null($this->worker())) {
            $request->session()->flash('warning', __('_dialog.group_null'));
            $groups = [];
        } else {
            $groups = $this->worker()->groups;
        }

        $studies    = config('constants.form_education');
        $docs       = Doc::get();

        return view(
            'admin.pages.members.form',
            compact('groups', 'studies', 'docs')
        );
    }

    public function store(Request $request)
    {
        $default_password = config('constants.password');
        $basic_seats      = Group::where('id', $request['group_id'])->first()->basic_seats;
        $extra_seats      = Group::where('id', $request['group_id'])->first()->extra_seats;
        $population       = Member::where([
            'group_id'   => $request['group_id'],
            'form_study' => $request['form_study']
        ])->count();

        if ($request['form_study'] == 0)
        {
            if ($population >= $basic_seats)
            {
                $request->session()->flash('warning', __('_dialog.free_full'));
                return redirect()->back();
            }
        }

        if ($request['form_study'] == 1)
        {
            if ($population >= $extra_seats)
            {
                $request->session()->flash('warning', __('_dialog.paid_full'));
                return redirect()->back();
            }
        }

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

        // TODO: client
        $user->permissions()->attach([19, 20]);

        Member::create([
            'user_id'       => $user->id,
            'last_name'     => ucfirst($request['last_name']),
            'first_name'    => ucfirst($request['first_name']),
            'middle_name'   => ucfirst($request['middle_name']),
            'group_id'      => $request['group_id'],
            'form_study'    => $request['form_study'],
            'doc_id'        => $request['doc_id'],
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

    public function edit(Request $request, Member $member)
    {
        if (is_null($this->worker())) {
            $request->session()->flash('warning', __('_dialog.group_null'));
            $groups = [];
        } else {
            $groups = $this->worker()->groups;
        }

        $studies    = config('constants.form_education');
        $docs       = Doc::get();

        return view(
            'admin.pages.members.form',
            compact('member', 'groups', 'studies', 'docs')
        );
    }

    public function update(Request $request, Member $member)
    {
        $basic_seats = Group::where('id', $request['group_id'])->first()->basic_seats;
        $extra_seats = Group::where('id', $request['group_id'])->first()->extra_seats;
        $condition   = $member->group_id == $request['group_id'] && $member->form_study == $request['form_study'];
        $population  = $condition
            ? Member::where(['group_id'   => $request['group_id'], 'form_study' => $request['form_study']])->count() - 1
            : Member::where(['group_id'   => $request['group_id'], 'form_study' => $request['form_study']])->count();

        if ($request['form_study'] == 0)
        {
            if ($population >= $basic_seats)
            {
                $request->session()->flash('warning', __('_dialog.free_full'));
                return redirect()->back();
            }
        }

        if ($request['form_study'] == 1)
        {
            if ($population >= $extra_seats)
            {
                $request->session()->flash('warning', __('_dialog.paid_full'));
                return redirect()->back();
            }
        }

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
            'group_id'      => $request['group_id'],
            'form_study'    => $request['form_study'],
            'doc_id'        => $request['doc_id'],
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
