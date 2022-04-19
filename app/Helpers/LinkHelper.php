<?php

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
