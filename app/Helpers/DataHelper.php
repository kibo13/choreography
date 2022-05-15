<?php

use Illuminate\Support\Facades\DB;

function sections()
{
    return DB::table('permissions')->select('name')->groupBy('name')->get();
}

        $last = $permission->name;
    }

    return $sections;
}
