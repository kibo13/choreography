<?php

use Illuminate\Support\Facades\Auth;

function is_active($route, $class)
{
    echo Route::currentRouteNamed($route) ? $class : '';
}

function is_update($param, $route)
{
    echo $param ?? null
            ? route($route . '.update', $param)
            : route($route . '.store');
}

function is_access($permission)
{
    return Auth::user()->permissions()->pluck('slug')->contains($permission);
}
