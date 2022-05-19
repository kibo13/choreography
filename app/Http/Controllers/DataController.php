<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function events()
    {
        return DB::table('events')
            ->select('events.name as title', 'events.from as start', 'events.till as end')
            ->get();
    }
}
