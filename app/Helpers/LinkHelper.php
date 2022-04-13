<?php

function is_active($route, $class)
{
    echo Route::currentRouteNamed($route) ? $class : '';
}
