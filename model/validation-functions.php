<?php

function validColor($color)
{
    global $f3;
    return in_array($color, $f3->get('colors'));
}

function validString($string)
{
    if(1 === preg_match('~[0-9]+~', $string) OR $string == null)
    {
        return false;
    }

    return true;
}