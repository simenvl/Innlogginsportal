<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "../models/Student.php";

    $student = new \models\Student();

    $student->get_courses();

    if($student->getCount() > 0)
    {
        echo json_encode($student->getResult());
    }
    else
    {
        $error = array("Fant ingen emner");

        echo json_encode($error);
    }





