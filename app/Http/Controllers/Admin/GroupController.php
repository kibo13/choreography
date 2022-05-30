<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Title;
use App\Models\Category;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        switch (Auth::user()->role_id) {
            case 3:
                $title_id = Auth::user()->worker->groups->pluck('title_id');
                $titles   = Title::whereIn('id', $title_id)->get();
                break;

            default:
                $titles   = Title::get();
                break;
        }

        return view('admin.pages.groups.index', compact('titles'));
    }

    public function create()
    {
        $titles     = Title::get();
        $categories = Category::get();
        $rooms      = Room::get();

        return view(
            'admin.pages.groups.form',
            compact('titles', 'categories', 'rooms')
        );
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
            'workload'     => $request['workload'],
            'room_id'      => $request['room_id'],
            'price'        => $request['price'] ?? null ? $request['price'] : 0,
            'lessons'      => $request['lessons'] ?? null ? $request['lessons'] : 0,
            'color'        => $request['color'],
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
        $titles     = Title::get();
        $categories = Category::get();
        $rooms      = Room::get();

        return view(
            'admin.pages.groups.form',
            compact('group', 'titles', 'categories', 'rooms')
        );
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
            'workload'     => $request['workload'],
            'room_id'      => $request['room_id'],
            'price'        => $request['price'] ?? null ? $request['price'] : 0,
            'lessons'      => $request['lessons'] ?? null ? $request['lessons'] : 0,
            'color'        => $request['color'],
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
