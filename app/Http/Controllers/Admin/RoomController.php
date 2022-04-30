<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::get();

        return view('admin.pages.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.pages.rooms.form');
    }

    public function store(RoomRequest $request)
    {
        Room::create($request->all());

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.rooms.index');
    }

    public function show(Room $room)
    {
        //
    }

    public function edit(Room $room)
    {
        return view('admin.pages.rooms.form', compact('room'));
    }

    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->all());

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.rooms.index');
    }

    public function destroy(Request $request, Room $room)
    {
        $room->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.rooms.index');
    }
}
