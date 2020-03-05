<?php session_start();

require_once "./dataaccess/anonym/report_user.php";
require_once "./classes/Validation.php";

if(isset($_POST['answer']) && isset($_POST['msg_id'])) {
    $validator = new \classes\Validation();
    $items = array(
        'answer' => array(
            'ruleName' => 'Svaret',
            'required' => true,
            'min' => 2,
            'max' => 300
        ),
        'msg_id' => array(
            'ruleName' => 'ID',
            'required' => true,
            'min' => 1,
            'max' => 11
        )
    );

    $inputValidation = $validator->checkUserInput($_POST, $items);

    if (!$inputValidation->getPassed()) {
        foreach ($inputValidation->getErrors() as $key => $val) {
            echo "<div class='container mt-4'><p class='text-danger'> {$val}</p></div>";
        }
    } else {
        if (array_key_exists('logged_in', $_SESSION)) {
            if ($_SESSION['logged_in'] == true && array_key_exists('lectur_id', $_SESSION)){
                $answer = report_user(
                    filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING),
                    filter_input(INPUT_POST, 'msg_id', FILTER_SANITIZE_NUMBER_INT),
                    null,
                    $_SESSION['lectur_id']

                );
                if ($answer) {
                    echo "<script>alert('Meldingen ble rapportert');</script>";
                    header("Refresh:0");
                } else {
                    echo "<div class='container mt-4'><p class='text-danger'>Det skjedde en feil. Prøv igjen senere.</p></div>";
                }
            }
            else if($_SESSION['logged_in'] == true && array_key_exists('user_id', $_SESSION))
            {
                $answer = report_user(
                    filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING),
                    filter_input(INPUT_POST, 'msg_id', FILTER_SANITIZE_NUMBER_INT),
                    $_SESSION['user_id'],
                    null

                );
                if ($answer) {
                    echo "<script>alert('Meldingen ble rapportert');</script>";
                    header("Refresh:0");
                } else {
                    echo "<div class='container mt-4'><p class='text-danger'>Det skjedde en feil. Prøv igjen senere.</p></div>";
                }
            }
        }
        else
        {
            $answer = report_user(
                filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING),
                filter_input(INPUT_POST, 'msg_id', FILTER_SANITIZE_NUMBER_INT),
                null,
                null
            );
            if ($answer) {
                echo "<script>alert('Meldingen ble rapportert');</script>";
                header("Refresh:0");
            } else {
                echo "<div class='container mt-4'><p class='text-danger'>Det skjedde en feil. Prøv igjen senere.</p></div>";
            }
        }
    }
}
