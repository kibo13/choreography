<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function events()
    {
        return DB::table('events')
            ->select([
                'events.id as event_id',
                'events.name as title',
                'events.from as start',
                'events.till as end',
                'events.description',
                'events.place',
//                DB::raw('\'background\' as display'),
            ])
            ->get();
    }

    public function timetable()
    {
        return DB::table('timetables')
            ->join('rooms', 'timetables.room_id', '=', 'rooms.id')
            ->join('workers', 'timetables.worker_id', '=', 'workers.id')
            ->join('groups', 'timetables.group_id', '=', 'groups.id')
            ->join('titles', 'groups.title_id', '=', 'titles.id')
            ->join('categories', 'groups.category_id', '=', 'categories.id')
            ->select([
                'timetables.id as timetable_id',
                'titles.name as group',
                'categories.name as category',
                'rooms.num as room',
                DB::raw('CONCAT_WS(\'-\', DATE_FORMAT(timetables.from, \'%H:%i\'), DATE_FORMAT(timetables.till, \'%H:%i\')) as title'),
                'timetables.from as start',
                'timetables.till as end',
                DB::raw('CONCAT_WS(\' \',workers.last_name, workers.first_name, workers.middle_name) as teacher'),
                'groups.color as backgroundColor',
                'timetables.worker_id',
                'groups.color as bgColor',
            ])
            ->get();
    }
}
