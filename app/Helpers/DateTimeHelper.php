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

function getNowYear()
{
    return Carbon::now()->year;
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

function getDayOfWeek($date)
{
    $dayOfWeek = date('w', strtotime($date));

    switch ($dayOfWeek) {
        case 1:
            $result = 'Понедельник';
            break;

        case 2:
            $result = 'Вторник';
            break;

        case 3:
            $result = 'Среда';
            break;

        case 4:
            $result = 'Четверг';
            break;

        case 5:
            $result = 'Пятница';
            break;

        case 6:
            $result = 'Суббота';
            break;

        case 0:
            $result = 'Воскресенье';
            break;
    }

    return $result;
}

function diffMonths($from, $till)
{
    $formatFrom = strtotime($from);
    $formatTill = strtotime($till);

    $yearFrom = date('Y', $formatFrom);
    $yearTill = date('Y', $formatTill);

    $monthFrom = date('m', $formatFrom);
    $monthTill = date('m', $formatTill);

    return $diff = (($yearTill - $yearFrom) * 12) + ($monthTill - $monthFrom) + 1;
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
