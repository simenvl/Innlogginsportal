<?php session_start();

require "header.php";

if(array_key_exists('logged_in', $_SESSION))
{
    if($_SESSION['logged_in'] == true && array_key_exists('user_id', $_SESSION))
    {
        require "./templates/student/user_logged_in.php";
    }
}
else
{
    require "./templates/default.php";
}

require "footer.php";
