<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Timetable;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    private function lessons($group, $month, $year)
    {
        return DB::table('timetables')
            ->select([
                'timetables.id',
                'timetables.from',
                'timetables.till',
                'timetables.worker_id',
                'timetables.method_id',
                'timetables.note',
                DB::raw('DATE(timetables.from) as date_lesson'),
                DB::raw('DATE_FORMAT(timetables.from, \'%d\') as day_lesson')
            ])
            ->where([
                ['group_id', $group->id],
                [DB::raw('MONTH(timetables.from)'), $month],
                [DB::raw('YEAR(timetables.from)'), $year],
            ])
            ->get();
    }

    private function lesson_days($group, $month, $year)
    {
        return DB::table('timetables')
            ->select([
                DB::raw('DATE(timetables.from) as date_lesson'),
                DB::raw('DATE_FORMAT(timetables.from, \'%d\') as day_lesson'),
                DB::raw('COUNT(timetables.from) as count_lesson'),
            ])
            ->where([
                ['group_id', $group->id],
                [DB::raw('MONTH(timetables.from)'), $month],
                [DB::raw('YEAR(timetables.from)'), $year],
            ])
            ->groupBy('date_lesson', 'day_lesson')
            ->get();
    }

    public function index(Request $request, Group $group)
    {
        // session rewrites
        if ($request->has('period'))
        {
            $request->session()->put('period.year', $request['year']);
            $request->session()->put('period.month', $request['month_id']);
        }

        // session exists
        if ($request->session()->has('period.year') && $request->session()->has('period.month'))
        {
            $isYear  = $request->session()->get('period.year');
            $isMonth = $request->session()->get('period.month');
        }

        // session doesn't exist
        else
        {
            $request->session()->put('period.year', $request['year']);
            $request->session()->put('period.month', $request['month_id']);

            $isYear  = $request->session()->get('period.year');
            $isMonth = $request->session()->get('period.month');
        }

        // dates
        $defaultYear  = 2022;  // default year  = 2022
        $defaultMonth = 6;     // default month = June
        $year         = $isYear ? $isYear : $defaultYear;
        $month        = $isMonth ? $isMonth : $defaultMonth;
        $months       = config('constants.months');
        $nameMonth    = config('constants.month_names')[$month - 1];

        // data
        $lessons      = $this->lessons($group, $month, $year);
        $lessonDays   = $this->lesson_days($group, $month, $year);

        if (count($lessons) == 0) {
            $request->session()->forget(['period.year', 'period.month']);
            $request->session()->put('period.year', $defaultYear);
            $request->session()->put('period.month', $defaultMonth);
            $request->session()->flash('warning', __('_dialog.period'));
            return redirect()->back();
        }

        return view('admin.pages.visits.index', [
            'group'       => $group,
            'months'      => $months,
            'nameMonth'   => $nameMonth,
            'numMonth'    => $month,
            'year'        => $year,
            'lessons'     => $lessons,
            'lessonDays'  => $lessonDays,
            'lessonCount' => $lessonDays->count(),
        ]);
    }

    public function topic_update(Request $request)
    {
        $timetable = Timetable::where('id', $request['timetable_id'])->first();

        $timetable->update([
            'method_id' => $request['method_id'],
            'note'      => $request['note']
        ]);

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->back();
    }

    public function visit_control(Request $request)
    {
        // create record
        if ($request['action'] == 'create')
        {
            Visit::create([
                'member_id'    => $request['member_id'],
                'timetable_id' => $request['timetable_id'],
                'status'       => $request['status'],
                'reason'       => $request['reason'],
            ]);
        }

        // update record
        if ($request['action'] == 'update')
        {
            $visit = Visit::where([
                ['member_id', $request['member_id']],
                ['timetable_id', $request['timetable_id']]
            ])->first();

            $visit->update([
                'status'       => $request['status'],
                'reason'       => $request['reason'],
            ]);
        }

        $request->session()->flash('success', __('_record.updated'));
        return redirect()->back();
    }

}
