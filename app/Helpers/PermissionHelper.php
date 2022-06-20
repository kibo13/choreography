<?php

use App\Models\Pass;
use App\Models\Group;
use App\Models\Load;
use App\Models\Method;
use App\Models\Member;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;

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

function getUsernameByRole()
{
    switch (Auth::user()->role_id) {
        case 3:
        case 4:
            $worker   = Auth::user()->worker;
            $username = $worker->first_name . ' ' . $worker->last_name;
            break;

        case 5:
            $member   = Auth::user()->member;
            $username = $member->first_name . ' ' . $member->last_name;
            break;

        default:
            $username = Auth::user()->username;
            break;
    }

    return $username;
}

function getGroupsByRole()
{
    switch (Auth::user()->role_id) {
        case 1:
        case 2:
        case 4:
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

function getSubteachers()
{
    switch (Auth::user()->role_id) {
        case 3:
            $groups      = Auth::user()->worker->groups->pluck('id');
            $subteachers = Timetable::whereIn('group_id', $groups)->get();
            break;

        default:
            $subteachers = [];
            break;
    }

    return $subteachers;
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

function getActivePass($member)
{
    return $member->passes->where('is_active', 1)->first();
}

function getDeactivePassesByGroup()
{
    switch (Auth::user()->role_id) {
        case 1:
        case 2:
        case 4:
            $passes = Pass::where('is_active', 0)->get();
            break;

        case 3:
            $groups = Auth::user()->worker->groups->pluck('id');
            $passes = Pass::whereIn('group_id', $groups)->where('is_active', 0)->get();
            break;

        case 4:
        case 5:
            $passes = [];
            break;
    }

    return $passes;
}

function getPaidMembersByGroup()
{
    switch (Auth::user()->role_id) {
        case 1:
        case 2:
        case 4:
            $groups  = Group::pluck('id');
            $members = Member::whereIn('group_id', $groups)->where('form_study', 1)->get();
            break;

        case 3:
            $groups  = Auth::user()->worker->groups->pluck('id');
            $members = Member::whereIn('group_id', $groups)->where('form_study', 1)->get();
            break;

        default:
            $members = [];
            break;
    }

    return $members;
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
