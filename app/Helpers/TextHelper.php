<?php

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
