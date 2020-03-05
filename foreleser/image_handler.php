<?php

function allowed_file($type, $size)
{
    $max = 2000000; // 2mb

    $allowed = array('image/jpeg', 'image/png');
    if(in_array($type, $allowed) && $size <= $max)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function upload_file($file, $tmp)
{
    $location = "uploads/";
    if(move_uploaded_file($tmp, $location.$file))
    {
        return true;
    }
    else
    {
        return false;
    }
}
