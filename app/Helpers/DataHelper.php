<?php

use Illuminate\Support\Facades\DB;

function sections()
{
    // permissions
    $permissions = DB::table('permissions')->select('name')->get();

    // empty array
    $sections = [];

    // previous item
    $last = null;

    foreach ($permissions as $permission) {

        if ($permission->name != $last) {
            array_push($sections, $permission->name);
        }

        $last = $permission->name;
    }

    return $sections;
}
