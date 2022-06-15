<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\Load;
use App\Models\Method;

function getMissesByMember($member, $month, $year)
{
    return DB::table('visits')
        ->join('timetables', 'visits.timetable_id', 'timetables.id')
        ->selectRaw('COUNT(visits.member_id) as count_misses')
        ->where([
            ['visits.status', 0],
            ['visits.member_id', $member],
            [DB::raw('MONTH(timetables.from)'), $month],
            [DB::raw('YEAR(timetables.from)'), $year],
        ])
        ->groupBy('visits.member_id')
        ->first()
        ->count_misses;
}

function getGroupsByRole()
{
    switch (Auth::user()->role_id) {
        case 1:
        case 2:
            $groups = Group::get();
            break;

        case 3:
            $groups = Auth::user()->worker->groups;
            break;

        default:
            $groups = [];
            break;
    }

    return $groups;
}

function getTeachersBySpec()
{
    switch (Auth::user()->role_id) {
        case 3:
            $teachers = DB::table('specialty_worker')
                ->join('specialties', 'specialty_worker.specialty_id', 'specialties.id')
                ->join('workers', 'specialty_worker.worker_id', 'workers.id')
                ->select([
                    'workers.id',
                    'workers.last_name',
                    'workers.first_name',
                    'workers.middle_name',
                    'workers.phone',
                    'workers.address',
                ])
                ->whereIn('specialties.id', Auth::user()->worker->specialties->pluck('id'))
                ->get();
            break;

        default:
            $teachers = [];
            break;
    }

    return $teachers;
}

function getMethodsByGroup()
{
    switch (Auth::user()->role_id) {
        case 1:
        case 2:
            $methods = Method::get();
            break;

        case 3:
            $groups  = Auth::user()->worker->groups->pluck('id');
            $methods = Method::whereIn('group_id', $groups)->get();
            break;

        default:
            $methods = [];
            break;
    }

    return $methods;
}

function getLoadsByRole()
{
    switch (Auth::user()->role_id) {
        case 3:
            $groups = Auth::user()->worker->groups->pluck('id');
            $loads  = Load::whereIn('group_id', $groups)->get();
            break;

        default:
            $loads  = [];
            break;
    }

    return $loads;
}
