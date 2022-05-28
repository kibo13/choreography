<?php

use Illuminate\Support\Facades\DB;
use App\Models\Diplom;
use App\Models\Orgkomitet;
use Illuminate\Support\Facades\Auth;

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

function getGroupsByDirector()
{
    switch (Auth::user()->role_id) {
        case 3:
            $groups = Auth::user()->worker->groups;
            break;

        default:
            $groups = [];
            break;
    }

    return $groups;
}

function getAllOrgcomitets()
{
    return Orgkomitet::get();
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
