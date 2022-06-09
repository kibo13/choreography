<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use App\Models\Load;

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
