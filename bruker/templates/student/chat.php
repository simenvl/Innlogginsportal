<?php

include_once "classes/DatabaseConnection.php";
include_once "classes/validation.php";
include_once "dataaccess/student/send_message.php";
include_once "templates/sendmessage.php";


if ( isset($_POST['sendMessage']) ) {

    $validator = new classes\Validation();
    $items = array(
        'course' => array(
            'ruleName' => 'Kurs',
            'required' => true,
            'min' => 1,
            'max' => 1
        ),
        'msg' => array(
            'ruleName' => 'Melding',
            'required' => true,
            'min' => 1,
            'max' => 500
        )
    );

    $inputValidation = $validator->checkUserInput($_POST, $items);

    if (!$inputValidation->getPassed()) {
        foreach ($inputValidation->getErrors() as $key => $val) {
            echo "<div class='container mt-4'><p class='text-danger'> {$val}</p></div>";
        }
    } else {
        $msg_sent = send_message(
            $_SESSION['user_id'],
            filter_input(INPUT_POST, 'course', FILTER_SANITIZE_NUMBER_INT),
            filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_STRING)
        );
        if ($msg_sent) {
            header('Location: ./index.php');
        } else {
            echo "<div class='container'><p class='alert-danger mt-4'>Det skjedde en feil. Prøv igjen senere.</p></div>";
        }
    }

}





