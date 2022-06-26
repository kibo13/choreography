<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Diplom;
use App\Models\Orgkomitet;
use App\Models\Load;
use App\Models\Member;
use App\Models\Method;
use App\Models\Title;
use App\Models\Application;
use App\Models\Pass;
use App\Models\Group;
use App\Models\Timetable;
use App\Models\Worker;
use App\Models\User;

// general
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
function command_master($master)
{
    // Surname N.M.

    $worker      = Worker::where('id', $master->id)->first();
    $last_name   = ucfirst($worker->last_name);
    $first_name  = substr($worker->first_name, 0, 2) . '.';
    $middle_name = isset($worker->middle_name) ? substr($worker->middle_name, 0, 2) . '.' : null;

    return $last_name . ' ' . $first_name . $middle_name;
}
function getShortFIO($type, $person_id)
{
    // Surname N.M.

    switch ($type)
    {
        case 'member':
            $person = Member::where('id', $person_id)->first();
            break;

        case 'worker':
            $person = Worker::where('id', $person_id)->first();
            break;

        default:
            $person = User::where('id', $person_id)->first();
            break;
    }

    $last_name   = ucfirst($person->last_name);
    $first_name  = substr($person->first_name, 0, 2) . '.';
    $middle_name = isset($person->middle_name) ? substr($person->middle_name, 0, 2) . '.' : null;

    return $last_name . ' ' . $first_name . $middle_name;
}
function getFIO($type, $person_id)
{
    // Surname FName MName

    switch ($type)
    {
        case 'member':
            $person = Member::where('id', $person_id)->first();
            break;

        case 'worker':
            $person = Worker::where('id', $person_id)->first();
            break;

        default:
            $person = User::where('id', $person_id)->first();
            break;
    }

    $last_name   = ucfirst($person->last_name) . ' ';
    $first_name  = ucfirst($person->first_name) . ' ';
    $middle_name = isset($person->middle_name) ? ucfirst($person->middle_name) : null;

    return $last_name . $first_name . $middle_name;
}
function getVisitsByType($member, $month, $year, $type)
{
    // types
    // 0 = miss
    // 1 = check
    // 2 = reason

    return DB::table('visits')
        ->join('timetables', 'visits.timetable_id', 'timetables.id')
        ->selectRaw('COUNT(visits.id) as count')
        ->whereIn('status', $type)
        ->where('visits.member_id', $member->id)
        ->where(DB::raw('MONTH(timetables.from)'), $month)
        ->where(DB::raw('YEAR(timetables.from)'), $year)
        ->first()
        ->count;
}
function getPass($member, $month, $year)
{
    return Pass::where('member_id', $member->id)
        ->where('month', $month)
        ->where('year', $year)
        ->first();
}

// navbar
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

// users
function sections()
{
    return DB::table('permissions')->select('name')->groupBy('name')->get();
}

// achievements
function diplom($achievement, $member)
{
    return Diplom::where(['achievement_id' => $achievement->id, 'member_id' => $member->id])->first();
}
function getAchievementsByYears($sort = 'DESC', $worker = [])
{
    return DB::table('events')
        ->join('achievements', 'events.id', '=', 'achievements.event_id')
        ->select(DB::raw('YEAR(events.from) as year'), DB::raw('COUNT(events.id) as total'))
        ->whereIn('events.worker_id', $worker)
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

// members
function getTotalExtraPlacesByTitle($title)
{
    $groups = Title::where('id', $title)->first()->groups->pluck('id');

    return Member::where('form_study', 1)->whereIn('group_id', $groups)->count();
}

// workers
function oneGroupByTeacher($categories, $position)
{
    switch ($position) {
        case 'head':
            $query = DB::table('groups')
                ->join('titles', 'titles.id', '=', 'groups.title_id')
                ->select('titles.name')
                ->whereIn('groups.id', $categories)
                ->groupBy('titles.name')
                ->get()
                ->count();
            $result = $query > 1 ? 'error' : 'success';
            break;

        case 'manager':
            $result = 'error';
            break;
    }

    return $result;
}

// visits
function getTopicByMethod($method)
{
    return Method::where('id', $method)->first();
}
function getMethodsByParams($group, $month)
{
    $month = is_null($month) ? Carbon::now()->month : $month;

    return Method::where('group_id', $group->id)->where('month_id', $month)->get();
}
function getYearsFromTimetables()
{
    return DB::table('timetables')
        ->selectRaw('YEAR(timetables.from) as year')
        ->groupBy('year')
        ->get();
}

// events
function getOrgcomitets()
{
    return Orgkomitet::get();
}

// loads
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

// timetable
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

// passes
function getPassesByRole()
{
    switch (Auth::user()->role_id) {
        case 1:
        case 2:
        case 4:
            $passes = Pass::orderBy('member_id')->get();
            break;

        case 3:
            $groups = Auth::user()->worker->groups->pluck('id');
            $passes = Pass::whereIn('group_id', $groups)->orderBy('member_id')->get();
            break;

        case 5:
            $member = Auth::user()->member->id;
            $passes = Pass::where('member_id', $member)->get();
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

// applications and support
function getAppsByRole()
{
    switch (Auth::user()->role_id) {
        case 1:
        case 2:
        case 4:
            $apps = Application::get();
            break;

        case 3:
            $groups = Auth::user()->worker->groups->pluck('id');
            $apps   = Application::whereIn('group_id', $groups)->orderBy('status')->get();
            break;

        case 5:
            $apps = Application::where('member_id', Auth::user()->member->id)->get();
            break;
    }

    return $apps;
}

// methods
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

// reports
function getPosition()
{
    switch (Auth::user()->role_id)
    {
        case 3:
            $position = 'Руководитель';
            break;

        default:
            $position = 'Заведующий';
            break;
    }

    return $position;
}
function getAuthorOfReport($worker)
{
    switch (Auth::user()->role_id)
    {
        case 3:
            $person = Worker::where('id', $worker->id)->first();
            break;

        default:
            $person = Worker::where('id', 4)->first();
            break;
    }

    $last_name   = ucfirst($person->last_name);
    $first_name  = substr($person->first_name, 0, 2) . '.';
    $middle_name = isset($person->middle_name) ? substr($person->middle_name, 0, 2) . '.' : null;

    return $last_name . ' ' . $first_name . $middle_name;
}
function getTitles()
{
    return Title::get();
}
function getWorkersID()
{
    switch (Auth::user()->role_id) {
        case 3:
            $workers = [Auth::user()->worker->id];
            break;

        default:
            $workers = Worker::pluck('id');
            break;
    }

    return $workers;
}

// stats
function getGroupNameByID($id)
{
    return Group::where('id', $id)->first();
}

