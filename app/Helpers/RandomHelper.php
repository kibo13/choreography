<?php

function bk_rand($param = null, $length = 13)
{
    $numbers = '0123456789';
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $prefix  = is_null($param) ? null : $param . '-';

    return is_null($param)
        ? substr(str_shuffle($numbers . $letters), 0, $length)
        : $prefix . substr(str_shuffle($numbers), 0, $length);
}
