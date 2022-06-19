<?php

use App\Models\Member;
use App\Models\Worker;
use App\Models\User;
use App\Models\Rep;

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

function short_fio($type, $id)
{
    switch ($type)
    {
        case 'member':
            $result = Member::where('id', $id)->first();
            break;

        case 'worker':
            $result = Worker::where('id', $id)->first();
            break;

        default:
            $result = User::where('id', $id)->first();
            break;
    }

    $first_name = ucfirst($result->first_name);
    $last_name  = substr($result->last_name, 0, 2) . '.';

    echo $first_name . ' ' . $last_name;
}

function full_fio($type, $id)
{
    switch ($type)
    {
        case 'member':
            $result = Member::where('id', $id)->first();
            break;

        case 'rep':
            $result = Rep::where('id', $id)->first();
            break;

        case 'worker':
            $result = Worker::where('id', $id)->first();
            break;

        default:
            $result = User::where('id', $id)->first();
            break;
    }

    $last_name   = ucfirst($result->last_name);
    $first_name  = substr($result->first_name, 0, 2) . '.';
    $middle_name = isset($result->middle_name) ? substr($result->middle_name, 0, 2) . '.' : null;

    echo '<span title="' . $result->last_name . ' '. $result->first_name . ' ' . $result->middle_name .'">' . $last_name . ' ' . $first_name . $middle_name . '</span>';
}

function command_master($master)
{
    $worker      = Worker::where('id', $master->id)->first();
    $last_name   = ucfirst($worker->last_name);
    $first_name  = substr($worker->first_name, 0, 2) . '.';
    $middle_name = isset($worker->middle_name) ? substr($worker->middle_name, 0, 2) . '.' : null;

    return $last_name . ' ' . $first_name . $middle_name;
}

function getFIO($type, $id)
{
    switch ($type)
    {
        case 'member':
            $result = Member::where('id', $id)->first();
            break;

        case 'worker':
            $result = Worker::where('id', $id)->first();
            break;

        default:
            $result = User::where('id', $id)->first();
            break;
    }

    $last_name   = ucfirst($result->last_name) . ' ';
    $first_name  = ucfirst($result->first_name) . ' ';
    $middle_name = isset($result->middle_name) ? ucfirst($result->middle_name) : null;

    return $last_name . $first_name . $middle_name;
}
