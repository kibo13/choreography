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
        $months      = config('constants.months');
        $nowMonthID  = Carbon::now()->format('m');
        $titles      = Title::get();

        return view(
            'admin.pages.timetable.index',
            compact('is_director', 'months', 'nowMonthID', 'titles')
        );
    }

    public function generate(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id != 3)
        {
            $request->session()->flash('warning', __('_dialog.just_head'));
            return redirect()->route('admin.timetable.index');
        }

        // settings
        $month             = $request['month_id'];
        $year              = Carbon::now()->format('Y');
        $numberDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $loads             = getLoadsByRole();

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
        for ($day = 1; $day <= $numberDaysInMonth; $day++)
        {
            $limit           = 4;
            $date            = $year . '-' . $month . '-' . $day;
            $numberDayOfWeek = date('w', strtotime($date));

            if (count($monthByDayOfWeek[$numberDayOfWeek]) < $limit)
            {
                array_push($monthByDayOfWeek[$numberDayOfWeek], $date);
            }
        }

        foreach ($loads as $load)
        {
            foreach ($monthByDayOfWeek[$load->day_of_week] as $date)
            {
                for ($lesson = 1; $lesson <= $load->duration; $lesson++)
                {
                    $from = $date . ' ' . @plusMinutes($load->start, 60 * ($lesson - 1));
                    $till = $date . ' ' . @plusMinutes($load->start, 45 + 60 * ($lesson - 1));
                    $code = @bk_code($load->group_id, $date, @plusMinutes($load->start, 60 * ($lesson - 1)));

                    if (Timetable::where('code', $code)->exists() == false)
                    {
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
}
