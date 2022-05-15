<?php

use Illuminate\Support\Facades\DB;
use App\Models\Diplom;

function sections()
{
    return DB::table('permissions')->select('name')->groupBy('name')->get();
}

function periods()
{
    return DB::table('events')
        ->join('achievements', 'events.id', '=', 'achievements.event_id')
        ->select(DB::raw('YEAR(events.from) as year'))
        ->groupBy('year')
        ->orderBy('year', 'DESC')
        ->get();
}

function diplom($achievement, $member)
{
    return Diplom::where(['achievement_id' => $achievement->id, 'member_id' => $member->id])->first();
}
