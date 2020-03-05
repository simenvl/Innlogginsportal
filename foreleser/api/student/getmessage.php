<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "../models/Student.php";

if(!empty($_GET['user_id']))
{
    if(filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT) && $_GET['user_id'] > 0)
    {
        $student = new \models\Student();
        $student->setUserId($_GET['user_id']);

        $student->get_message();

        if($student->getCount() > 0)
        {
            echo json_encode($student->getResult());
        }
        else
        {
            $error = array("Fant ingen meldinger");
            echo json_encode($error);
        }

    }
}
