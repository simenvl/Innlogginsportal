<?php session_start();

require_once "header.php";

if(array_key_exists('logged_in', $_SESSION))
{
    if($_SESSION['logged_in'] == true && array_key_exists('lectur_id', $_SESSION))
    {
        require_once "./templates/lectur/lectur_logged_in.php";
    }
    else if($_SESSION['logged_in'] == true && array_key_exists('admin_id', $_SESSION))
    {
        require_once "./templates/admin/admin_logged_in.php";
    }
}

else
{
    require_once "./templates/default.php";
}


require_once "footer.php";
