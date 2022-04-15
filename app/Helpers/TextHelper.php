<?php

function form_title($param)
{
    echo $param ?? null
            ? __('crud.edit_record')
            : __('crud.new_record');
}
