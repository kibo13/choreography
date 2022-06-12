<?php

use Illuminate\Support\Facades\DB;
use App\Models\Diplom;
use App\Models\Room;
use App\Models\Orgkomitet;
use App\Models\Load;
use App\Models\Method;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

function sections()
{
    return DB::table('permissions')->select('name')->groupBy('name')->get();
}

function getAchievementsByYears($sort = 'DESC', $worker = null)
{
    return DB::table('events')
                ->join('achievements', 'events.id', '=', 'achievements.event_id')
                ->select(DB::raw('YEAR(events.from) as year'), DB::raw('COUNT(events.id) as total'))
                ->where('events.worker_id', $worker)
                ->groupBy('year')
                ->orderBy('year', $sort)
                ->get();
}

function getAchievementsByMonths($year = '2020', $worker = null)
{
    $query = DB::table('events')
        ->join('achievements', 'events.id', '=', 'achievements.event_id')
        ->select(DB::raw('MONTH(events.from) as month'), DB::raw('COUNT(events.id) as total'))
        ->where(DB::raw('YEAR(events.from)'), $year)
        ->where('events.worker_id', $worker)
        ->groupBy('month')
        ->get();

    for ($month = 1; $month <= 12; $month++)
    {
        if ($query->where('month', $month)->first()->total) {
            $result .= $month . ',' . $query->where('month', $month)->first()->total . ',';
        } else {
            $result .= $month . ',' . 0 . ',';
        }
    }

    return $result;
}

function diplom($achievement, $member)
{
    return Diplom::where(['achievement_id' => $achievement->id, 'member_id' => $member->id])->first();
}

function getAllRooms()
{
    return Room::get();
}

function getMethodsByParams($group, $month)
{
    $month = is_null($month) ? Carbon::now()->month : $month;

    return Method::where('group_id', $group->id)->where('month_id', $month)->get();
}

function getTopicByMethod($method)
{
    return Method::where('id', $method)->first();
}

function getYearsFromTimetables()
{
    return DB::table('timetables')
        ->selectRaw('YEAR(timetables.from) as year')
        ->groupBy('year')
        ->get();
}

function getTeachers()
{
    return DB::table('workers')
        ->join('users', 'workers.user_id', '=', 'users.id')
        ->select([
            'workers.id',
            'workers.last_name',
            'workers.first_name',
            'workers.middle_name',
            'workers.phone',
            'workers.address',
        ])
        ->where('users.role_id', 3)
        ->get();
}

function checkVisit($member, $lesson)
{
    return Visit::where('member_id', $member->id)->where('timetable_id', $lesson->id)->first();
}

function getAllOrgcomitets()
{
    return Orgkomitet::get();
}

function getLoadsByDayOfWeek($day_of_week)
{
    switch (Auth::user()->role_id) {
        case 3:
            $groups = Auth::user()->worker->groups->pluck('id');
            $loads  = Load::whereIn('group_id', $groups)->where('day_of_week', $day_of_week)->get();
            break;

        default:
            $loads  = Load::where('day_of_week', $day_of_week)->get();
    }

    return $loads;
}

function fillHours($hour, $load, $duration)
{
    $formatHour = date('H', strtotime($hour));
    $formatLoad = date('H', strtotime($load));
    $diff       = $formatHour - $formatLoad;

    return $formatHour >= $formatLoad && $diff < $duration ? true : false;
}

function load($group, $day_of_week, $field = null)
{
    $load = $group->loads->where('day_of_week', $day_of_week);

    if (is_null($field))
    {
        return $load->count();
    }

    else
    {
        return $load->first()->$field;
    }
}
