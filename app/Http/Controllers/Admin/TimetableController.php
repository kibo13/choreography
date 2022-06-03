<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\Title;
use App\Models\Load;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimetableController extends Controller
{
    public function index()
    {
        $is_director = Auth::user()->role_id == 3 ? 1 : null;
        $titles      = Title::get();

        return view(
            'admin.pages.timetable.index',
            compact('is_director', 'titles')
        );
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id != 3)
        {
            $request->session()->flash('warning', __('_dialog.just_head'));
            return redirect()->route('admin.timetable.index');
        }

        // loads
        $groups = $user->worker->groups->pluck('id');
        $loads  = Load::whereIn('group_id', $groups)->get();

        // now
        $nowYear               = Carbon::now()->format('Y');
        $numberNowMonth        = Carbon::now()->format('m');
        $numberNowDay          = Carbon::now()->format('d');
        $numberDaysInMonth     = Carbon::now()->daysInMonth;

        // next
        $nextYear              = Carbon::now()->addYear()->format('Y');
        // TODO: need change condition
        $numberNextMonth       = Carbon::now()->addDays(30)->format('m');
        $numberNextDay         = Carbon::now()->addDay()->format('d');
        $numberDaysInNextMonth = Carbon::now()->addMonth()->daysInMonth;

        // init values
        $beforeDays            = 5;
        $diff                  = $numberDaysInMonth - $numberNowDay;
        $year                  = $diff < $beforeDays && $numberNowMonth == 12 ? $nextYear : $nowYear;
        $month                 = $diff < $beforeDays ? $numberNextMonth : $numberNowMonth;
        $start                 = $diff < $beforeDays ? 1 : $numberNextDay;
        $end                   = $diff < $beforeDays ? $numberDaysInNextMonth : $numberDaysInMonth;

        // create empty array monthByDayOfWeek
        $monthByDayOfWeek = [
            0 => [], // SUNDAY
            1 => [], // MONDAY
            2 => [], // TUESDAY
            3 => [], // WEDNESDAY
            4 => [], // THURSDAY
            5 => [], // FRIDAY
            6 => [], // SATURDAY
        ];

        // fill array monthByDayOfWeek
        for ($day = $start; $day <= $end; $day++)
        {
            $date            = $year . '-' . $month . '-' . $day;
            $numberDayOfWeek = date('w', strtotime($date));
            array_push($monthByDayOfWeek[$numberDayOfWeek], $date);
        }

        // create timetable
        foreach ($loads as $load)
        {
            foreach ($monthByDayOfWeek[$load->day_of_week] as $date)
            {
                for ($lesson = 1; $lesson <= $load->duration; $lesson++)
                {
                    $from      = $date . ' ' . @plusMinutes($load->start, 60 * ($lesson - 1));
                    $till      = $date . ' ' . @plusMinutes($load->start, 45 + 60 * ($lesson - 1));
                    $code      = $load->group_id . '-' . $from . '-' . $till;
                    $condition = Timetable::where('code', $code)->exists();

                    if (!$condition) {
                        Timetable::create([
                            'code'       => $code,
                            'group_id'   => $load->group_id,
                            'room_id'    => $load->room_id,
                            'from'       => $from,
                            'till'       => $till,
                            'worker_id'  => $user->worker->id,
                            'is_replace' => $user->worker->id,
                        ]);
                    }
                }
            }
        }

        $request->session()->flash('success', 'Расписание готово');
        return redirect()->route('admin.timetable.index');
    }

    public function edit(Request $request)
    {
        $timetable = Timetable::where('id', $request['timetable_id'])->first();
        $timetable->update([
            'worker_id' => $request['worker_id']
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->route('admin.timetable.index');
    }

    public function destroy(Timetable $timetable)
    {
        //
    }
}
