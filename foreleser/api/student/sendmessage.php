<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once "../models/Student.php";
require_once "../../classes/Validation.php";

$data = json_decode(file_get_contents("php://input"), true);

if(!is_null($data))
{
    $validator = new \classes\Validation();
    $items = array(
        'student' => array(
            'ruleName' => 'Bruker ID',
            'required' => true,
            'min' => 1,
            'max' => 11
        ),
        'lectur' => array(
            'ruleName' => 'Foreleser',
            'required' => true,
            'min' => 1,
            'max' => 11
        ),
        'msg' => array(
            'ruleName' => 'Meldingen',
            'required' => true,
            'min' => 2,
            'max' => 300
        ),
        'course_id' => array(
            'ruleName' => 'id',
            'required' => true,
            'min' => 1,
            'max' => 7
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

        $student->setUserId(filter_var($data['student'], FILTER_SANITIZE_NUMBER_INT));
        $student->setCourse(filter_var($data['lectur'], FILTER_SANITIZE_NUMBER_INT));

        $student->send_message(filter_var($data['msg'], FILTER_SANITIZE_STRING), filter_var($data['course_id'], FILTER_SANITIZE_NUMBER_INT));

        if($student->getError())
        {
            $error = array('Det skjedde en feil. Prøv igjen senere');
            echo json_encode($error);
        }
        else
        {
            $message_arr = array(
                'msg_id' => $student->getMessageId(),
                'student' => $student->getUserId(),
                'lectur' => $student->getCourse(),
                'msg' => filter_var($data['msg'], FILTER_SANITIZE_STRING),
                'course_id' => filter_var($data['course_id'], FILTER_SANITIZE_NUMBER_INT)
            );

            echo json_encode($message_arr);
        }

    }
}


