<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::get();
        $titles = Title::get();

        return view('admin.pages.events.index', compact('events', 'titles'));
    }

    public function create(Request $request)
    {
        $types = config('constants.types');

        switch (Auth::user()->role_id) {
            case 3:
                $groups = Auth::user()->worker->groups;
                break;

            default:
                $groups = [];
                $request->session()->flash('warning', __('_dialog.group_null'));
                break;
        }

        return view('admin.pages.events.form', compact('types', 'groups'));
    }

    public function store(Request $request)
    {
        $event = Event::create($request->all());

        if ($request->input('groups')) :
            $event->groups()->attach($request->input('groups'));
        endif;

        $request->session()->flash('success', __('_record.added'));
        return redirect()->route('admin.events.index');
    }

    public function show(Event $event)
    {
        //
    }

    public function edit(Request $request, Event $event)
    {
        $types = config('constants.types');

        switch (Auth::user()->role_id) {
            case 3:
                $groups = Auth::user()->worker->groups;
                break;

            default:
                $groups = [];
                $request->session()->flash('warning', __('_dialog.group_null'));
                break;
        }

        return view('admin.pages.events.form', compact('event', 'types', 'groups'));
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());
        $event->groups()->detach();

        if ($request->input('groups')) :
            $event->groups()->attach($request->input('groups'));
        endif;

        $event->save();

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.events.index');
    }

    public function destroy(Request $request, Event $event)
    {
        $event->groups()->detach();
        $event->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.events.index');
    }
}
