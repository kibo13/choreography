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
    $formattedDate = str_replace('-', '', $date);
    $formattedTime = str_replace(':', '', $time);

    if (iconv_strlen($formattedDate) == 7)
    {
        $formattedDate = substr_replace($formattedDate, '0', 6, 0);
    }

    return $group . $formattedDate . $formattedTime;
}
