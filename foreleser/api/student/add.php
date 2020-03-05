<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once "../models/Student.php";
require_once "../../classes/Validation.php";
require_once "../../crypt.php";


$data = json_decode(file_get_contents("php://input"), true);

if(!is_null($data))
{
    $validator = new \classes\Validation();
    $items = array(
        'name' => array(
            'ruleName' => 'Navn',
            'required' => true,
            'min' => 2,
            'max' => 60
        ),
        'email' => array(
            'ruleName' => 'E-postadresse',
            'required' => true,
            'emailVerify' => $data['email'],
            'max' => 120
        ),
        'password' => array(
            'ruleName' => 'Passord',
            'required' => true,
            'min' => 6,
            'max' => 20
        ),
        'course' => array(
            'ruleName' => 'Studie',
            'required' => true,
            'min' => 1,
            'max' => 20
        ),
        'year' => array(
            'ruleName' => 'Kull',
            'required' => true,
            'min' => 4,
            'max' => 4
        )
    );

    $inputValidation = $validator->checkUserInput($data, $items);

    if(!$inputValidation->getPassed())
    {
        $error = array($inputValidation->getErrors());
        echo json_encode($error);
    }
    else
    {
        $student = new \models\Student();

        $student->setName(filter_var($data['name'], FILTER_SANITIZE_STRING));
        $student->setEmail(filter_var($data['email'], FILTER_SANITIZE_STRING));
        $student->setPassword(crypt_pw(filter_var($data['password'], FILTER_SANITIZE_STRING)));
        $student->setCourse(filter_var($data['course'], FILTER_SANITIZE_STRING));
        $student->setYear(filter_var($data['year'], FILTER_SANITIZE_STRING));

        $student->create();

        if($student->getError())
        {
            $error = array("Det skjedde en feil. Prøv igjen senere");
            echo json_encode($error);
        }
        else
        {
            $student_arr = array(
                'user_id' => (int) $student->getUserId(),
                'name' => $student->getName(),
                'email' => $student->getEmail(),
                'password' => $student->getPassword(),
                'course' => (int) $student->getCourse(),
                'year' => (int) $student->getYear(),
            );

            echo json_encode($student_arr);

        }

    }
}


