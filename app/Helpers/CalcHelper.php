<?php

function full_age($birthday)
{
    $diff = date( 'Ymd' ) - date( 'Ymd', strtotime($birthday) );

    return substr( $diff, 0, -4 );
}
