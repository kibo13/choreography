<?php

use Carbon\Carbon;

function getCurrentDay()
{
    return Carbon::now()->addHour(5)->format('Y-m-d');
}

function getToday()
{
    return date('d.m.Y', strtotime(getCurrentDay()));
}

function getDMY($date)
{
    return date('d.m.Y', strtotime($date));
}

function getHI($time)
{
    return date('H:i', strtotime($time));
}
