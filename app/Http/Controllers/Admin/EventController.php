<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    private function worker()
    {
        return Auth::user()->worker;
    }

    public function index()
    {
        switch (Auth::user()->role_id)
        {
            case 3:
                $events = Event::where('worker_id', $this->worker()->id)->get();
                break;

            default:
                $events = Event::get();
                break;
        }

        return view('admin.pages.events.index', compact('events'));
    }

    public function create(Request $request)
    {
        $types = config('constants.types');

        switch (Auth::user()->role_id) {
            case 3:
                $groups  = Auth::user()->worker->groups;
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
        if (Auth::user()->role_id != 3) {
            $request->session()->flash('warning', __('_dialog.just_head'));
            return redirect()->back();
        }

        Event::create([
            'type'      => $request['type'],
            'name'      => $request['name'],
            'from'      => $request['from'],
            'till'      => $request['till'],
            'place'     => $request['place'],
            'group_id'  => $request['group_id'],
            'worker_id' => Auth::user()->worker->id,
        ]);

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
                $members = $event->group->members;
                break;

            default:
                $members = [];
                $request->session()->flash('warning', __('_dialog.group_null'));
                break;
        }

        return view('admin.pages.events.form', compact('event', 'types', 'members'));
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());
        $event->members()->detach();

        if ($request->input('members')) :
            $event->members()->attach($request->input('members'));
        endif;

        $event->save();

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.events.index');
    }

    public function destroy(Request $request, Event $event)
    {
        $event->members()->detach();
        $event->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.events.index');
    }
}
