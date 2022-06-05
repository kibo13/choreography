<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Group;
use App\Models\Orgkomitet;
use Illuminate\Http\Request;
use App\Http\Requests\AwardRequest;
use Illuminate\Support\Facades\Auth;

class AwardController extends Controller
{
    private function groups()
    {
        switch (Auth::user()->role_id)
        {
            case 3:
                $groups = Auth::user()->worker->groups->pluck('id');
                break;

            default:
                $groups = Group::pluck('id');
        }

        return $groups;
    }

    private function role()
    {
        return Auth::user()->role_id;
    }

    public function index()
    {
        $awards = Award::whereIn('group_id', $this->groups())->get();

        return view('admin.pages.awards.index', compact('awards'));
    }

    public function create()
    {
        $groups     = $this->role() == 3 ? Group::whereIn('id', $this->groups())->get() : [];
        $organizers = Orgkomitet::get();

        return view('admin.pages.awards.form', compact('groups', 'organizers'));
    }

    public function store(AwardRequest $request)
    {
        Award::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.awards.index');
    }

    public function show(Award $award)
    {
        //
    }

    public function edit(Award $award)
    {
        $groups     = $this->role() == 3 ? Group::whereIn('id', $this->groups())->get() : [];
        $organizers = Orgkomitet::get();

        return view('admin.pages.awards.form', compact('award', 'groups', 'organizers'));
    }

    public function update(AwardRequest $request, Award $award)
    {
        $award->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.awards.index');
    }

    public function destroy(Request $request, Award $award)
    {
        $award->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.awards.index');
    }
}
