<?php

function double($amount, $decimal = 2)
{
    echo number_format($amount, $decimal, '.', ' ');
}

