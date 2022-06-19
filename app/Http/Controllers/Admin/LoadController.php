<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Load;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoadController extends Controller
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

        $daysOfWeek = config('constants.days_of_week');
        $dayByHours = config('constants.day_by_hours');

        return view(
            'admin.pages.loads.index',
            compact('titles', 'daysOfWeek', 'dayByHours')
        );
    }

    public function create_or_update(Request $request)
    {
        $query = DB::table('loads')
            ->where('day_of_week', $request['day_of_week'])
            ->where('room_id', $request['room_id'])
            ->where('group_id', '<>', $request['group_id'])
            ->first();

        if (!is_null($query)) {
            $minTime = date('H:i', strtotime($query->start));
            $maxTime = date('H:i', strtotime('+' . $query->duration - 1 . ' hour', strtotime($query->start)));

            for ($lesson = 1; $lesson <= $request['duration']; $lesson++)
            {
                $lessonTime = date('H:i', strtotime('+' . 1 * ($lesson - 1) . ' hour', strtotime($request['start'])));

                if ($lessonTime >= $minTime && $lessonTime <= $maxTime)
                {
                    $request->session()->flash('warning', __('_dialog.room_busy'));
                    return redirect()->back();
                }
            }
        }

        $group             = Group::where('id', $request['group_id'])->first();
        $limitHoursByGroup = $group->workload / 4;
        $existHoursByGroup = $group->getTotalHours();

        switch ($request['action']) {
            case 'create':
                $totalHoursByGroup = $existHoursByGroup + $request['duration'];
                break;

            case 'update':
                $oldDuration       = $group->loads->where('day_of_week', $request['day_of_week'])->first()->duration;
                $totalHoursByGroup = $existHoursByGroup - $oldDuration + $request['duration'];
                break;
        }

        if ($totalHoursByGroup > $limitHoursByGroup)
        {
            $request->session()->flash('warning', __('_dialog.limit_week'));
            return redirect()->route('admin.loads.index');
        }

        // create load record
        if ($request['action'] == 'create')
        {
            Load::create($request->all());

            $request->session()->flash('success', __('_record.added'));
            return redirect()->route('admin.loads.index');
        }

        // update load record
        if ($request['action'] == 'update')
        {
            $load = Load::where([
                'group_id'    => $request['group_id'],
                'day_of_week' => $request['day_of_week']
            ])->first();

            $load->update([
                'room_id'     => $request['room_id'],
                'start'       => $request['start'],
                'duration'    => $request['duration'],
            ]);

            $request->session()->flash('success', __('_record.updated'));
            return redirect()->route('admin.loads.index');
        }
    }

    public function destroy(Request $request, Load $load)
    {
        $load->delete();

        $request->session()->flash('success', __('_record.deleted'));
        return redirect()->route('admin.loads.index');
    }
}
