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

function getDateTime($param)
{
    return str_replace(' ', 'T', $param);
}

function getDMY($date)
{
    return date('d.m.Y', strtotime($date));
}

function getDM($date)
{
    return date('d.m', strtotime($date));
}

function getHI($time)
{
    return date('H:i', strtotime($time));
}

function diffDays($date)
{
    return Carbon::now()->diffInDays($date);
}

function plusMinutes($time, $minutes)
{
    return date('H:i', strtotime('+' . $minutes . ' minutes', strtotime($time)));
}

function full_age($birthday)
{
    $diff = date( 'Ymd' ) - date( 'Ymd', strtotime($birthday) );

    return substr( $diff, 0, -4 );
}

function fillHours($hour, $load, $duration)
{
    $formatHour = date('H', strtotime($hour));
    $formatLoad = date('H', strtotime($load));
    $diff       = $formatHour - $formatLoad;

    return $formatHour >= $formatLoad && $diff < $duration ? true : false;
}
