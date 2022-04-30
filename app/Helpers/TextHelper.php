<?php

use App\Models\User;

function form_title($param)
{
    echo $param ?? null
            ? __('_record.edit')
            : __('_record.new');
}

function mandatory()
{
    echo '<span class="bk-field bk-field--mandatory">*</i>';
}

function tip($message)
{
    echo '<span class="bk-field bk-field--tip">' . $message .'</span>';
}

function no_record($record, $replace = null)
{
    echo $record ?? null
            ? $record
            : '<span class="text-info">' . $replace .'</span>';
}

function status($param)
{
    echo $param == 0
        ? '<strong class="text-info">' . __('_action.pending') .'</strong>'
        : '<strong class="text-success">' . __('_action.completed') .'</strong>';
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

    $last_name    = ucfirst($user->last_name);
    $first_name   = substr($user->first_name, 0, 2) . '.';
    $middle_name  = isset($user->middle_name) ? substr($user->middle_name, 0, 2) . '.' : null;

    echo '<span title="' . $user->last_name . ' '. $user->first_name . ' ' . $user->middle_name .'">' . $last_name . ' ' . $first_name . $middle_name . '</span>';
}
