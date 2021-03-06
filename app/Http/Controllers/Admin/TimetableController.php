<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    private function getLessonsLimit($groups)
    {
        return DB::table('loads')
            ->selectRaw('SUM(loads.duration) as lessons')
            ->whereIn('group_id', $groups)
            ->first()
            ->lessons;
    }

    private function getLessonsExist($groups, $month, $year)
    {
        return DB::table('timetables')
            ->selectRaw('COUNT(timetables.id) as lessons')
            ->whereIn('group_id', $groups)
            ->where(DB::raw('MONTH(timetables.from)'), $month)
            ->where(DB::raw('YEAR(timetables.from)'), $year)
            ->first()
            ->lessons;
    }

    public function index()
    {
        $is_director = Auth::user()->role_id == 3 ? 1 : null;
        $titles      = Title::get();
        $subteachers = @getSubteachers();
        $k           = 0;

        return view('admin.pages.timetable.index', [
            'is_director' => $is_director,
            'titles'      => $titles,
            'subteachers' => $subteachers,
            'k'           => $k
        ]);
    }

    public function generate(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id != 3)
        {
            $request->session()->flash('warning', __('_dialog.just_head'));
            return redirect()->route('admin.timetable.index');
        }

        $year  = explode('-', $request['month'])[0];
        $month = explode('-', $request['month'])[1];

        if ($month == 7 || $month == 8)
        {
            $request->session()->flash('warning', 'Расписание не может быть сформировано за Июль-Август месяцы');
            return redirect()->route('admin.timetable.index');
        }

        $numberDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $loads             = getLoadsByRole();
        $groups            = Auth::user()->worker->groups->pluck('id');
        $existLessons      = $this->getLessonsExist($groups, $month, $year);
        $limitLessons      = $this->getLessonsLimit($groups) * 4;
        $month_names       = config('constants.month_names');

        if ($existLessons == $limitLessons)
        {
            $request->session()->flash('success', 'Расписание за ' . $month_names[$month - 1] . ' месяц уже сформировано');
            return redirect()->route('admin.timetable.index');
        }

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
