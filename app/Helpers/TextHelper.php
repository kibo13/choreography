<?php

use App\Models\User;

function form_title($param)
{
    echo $param ?? null
            ? __('crud.edit_record')
            : __('crud.new_record');
}

function mandatory()
{
    echo '<span class="bk-mandatory">*</i>';
}

function tip($message)
{
    echo '<span class="bk-tip">' . $message .'</i>';
}

function short_fio($id)
{
    $user = User::where('id', $id)->first();

    $first_name     = ucfirst($user->first_name);
    $last_name      = substr($user->last_name, 0, 2) . '.';

    echo $first_name . ' ' . $last_name;
}

function full_fio($id)
{
    $user = User::where('id', $id)->first();

    $first_name     = ucfirst($user->first_name);
    $last_name      = substr($user->last_name, 0, 2) . '.';
    $middle_name    = isset($user->middle_name) ? substr($user->middle_name, 0, 2) . '.' : null;

    echo $first_name . ' ' . $last_name . $middle_name;
}
