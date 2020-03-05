<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "../models/Student.php";
require_once "../../classes/Validation.php";

if(!empty($_SERVER['HTTP_EMAIL']) && !empty($_SERVER['HTTP_PASSWORD']))
{
    $validator = new \classes\Validation();
    $items = array(
        'HTTP_EMAIL' => array(
            'ruleName' => 'E-postadresse',
            'required' => true,
            'emailVerify' => $_SERVER['HTTP_EMAIL'],
            'max' => 120
        ),
        'HTTP_PASSWORD' => array(
            'ruleName' => 'Passord',
            'required' => true,
            'max' => 20,
            'min' => 6
        )
    );

    $inputValidation = $validator->checkUserInput($_SERVER, $items);

    if(!$inputValidation->getPassed())
    {
        echo json_encode($inputValidation->getErrors());
    }
    else
    {
        $student = new \models\Student();
        $student->get($_SERVER['HTTP_EMAIL']);

        if($student->getCount() > 0)
        {
            if(password_verify(filter_input(INPUT_SERVER, 'HTTP_PASSWORD', FILTER_SANITIZE_STRING), $student->getPassword()))
            {
                $student_arr = array(
                    'user_id' => (int) $student->getUserId(),
                    'name' => $student->getName(),
                    'email' => $student->getEmail(),
                    'password' => $student->getPassword(),
                    'course' => (int) $student->getCourse(),
                    'year' => (int) $student->getYear(),
                );

                $success = array($student_arr);

                echo json_encode($success);
            }

            else
            {
                $error = array("Brukernavn og/eller passord er feil");
                echo json_encode($error);
            }
        }
        else
        {
            $error = array('Fant ingen brukere med den e-postadressen');

            echo json_encode($error);
        }

    }
}




