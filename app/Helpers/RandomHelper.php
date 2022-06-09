<?php

function bk_rand($type, $param = null, $length = 13)
{
    $numbers = '0123456789';
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $prefix  = is_null($param) ? null : $param . '-';

    switch ($type)
    {
        case 'number':
            $result = substr(str_shuffle($numbers), 0, $length);
            break;

        case 'string':
            $result = substr(str_shuffle($letters), 0, $length);
            break;

        case 'login':
            $result = $prefix . substr(str_shuffle($numbers), 0, $length);
            break;

        default:
            $result = substr(str_shuffle($numbers . $letters), 0, $length);
            break;
    }

    return $result;
}

function bk_code($group, $date, $time)
{
    $formattedTime = str_replace(':', '', $time);
    $formattedDate = explode('-', $date);
    $year          = $formattedDate[0];
    $month         = strlen($formattedDate[1]) == 1 ? '0' . $formattedDate[1] : $formattedDate[1];
    $day           = strlen($formattedDate[2]) == 1 ? '0' . $formattedDate[2] : $formattedDate[2];

    return $group . $year . $month . $day . $formattedTime;
}
