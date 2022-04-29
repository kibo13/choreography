<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Title;
use App\Models\Category;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $titles         = Title::get();

        return view('admin.pages.groups.index', compact('titles'));
    }

    public function create()
    {
        $titles         = Title::get();
        $categories     = Category::get();

        return view('admin.pages.groups.form', compact('titles', 'categories'));
    }

    public function store(Request $request)
    {
        Group::create([
            'title_id'     => $request['title_id'],
            'category_id'  => $request['category_id'],
            'basic_seats'  => $request['basic_seats'],
            'extra_seats'  => $request['extra_seats'] ?? null ? $request['extra_seats'] : 0,
            'age_from'     => $request['age_from'],
            'age_till'     => $request['age_till'],
            'price'        => $request['price'] ?? null ? $request['price'] : 0,
            'lessons'      => $request['lessons'] ?? null ? $request['lessons'] : 0,
            'note'         => $request['note'],
        ]);

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.groups.index');
    }

    public function show(Group $group)
    {
        //
    }

    public function edit(Group $group)
    {
        $titles         = Title::get();
        $categories     = Category::get();

        return view('admin.pages.groups.form', compact('group', 'titles', 'categories'));
    }

    public function update(Request $request, Group $group)
    {
        $group->update([
            'title_id'     => $request['title_id'],
            'category_id'  => $request['category_id'],
            'basic_seats'  => $request['basic_seats'],
            'extra_seats'  => $request['extra_seats'] ?? null ? $request['extra_seats'] : 0,
            'age_from'     => $request['age_from'],
            'age_till'     => $request['age_till'],
            'price'        => $request['price'] ?? null ? $request['price'] : 0,
            'lessons'      => $request['lessons'] ?? null ? $request['lessons'] : 0,
            'note'         => $request['note'],
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.groups.index');
    }

    public function destroy(Request $request, Group $group)
    {
        $group->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.groups.index');
    }
}
