<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "../models/Student.php";

if(!empty($_GET['lectur_id']))
{
    if(filter_input(INPUT_GET, 'lectur_id', FILTER_VALIDATE_INT) && $_GET['lectur_id'] > 0)
    {
        $student = new \models\Student();

        $student->get_image($_GET['lectur_id']);

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