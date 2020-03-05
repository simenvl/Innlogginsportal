<?php session_start();

require_once "./dataaccess/anonym/comment_user.php";
require_once "./classes/Validation.php";

if(isset($_POST['comment']) && isset($_POST['message_id'])) {
    $validator = new \classes\Validation();
    $items = array(
        'comment' => array(
            'ruleName' => 'Kommentaren',
            'required' => true,
            'min' => 2,
            'max' => 300
        ),
        'message_id' => array(
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
                $answer = comment_user(
                    filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING),
                    filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_NUMBER_INT),
                    null,
                    $_SESSION['lectur_id']

                );
                if ($answer) {
                    echo "<script>alert('Kommentaren ble lagt til');</script>";
                    header("Refresh:0");
                } else {
                    echo "<div class='container mt-4'><p class='text-danger'>Det skjedde en feil. Prøv igjen senere.</p></div>";
                }
            }
            else if($_SESSION['logged_in'] == true && array_key_exists('user_id', $_SESSION))
            {
                $answer = comment_user(
                    filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING),
                    filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_NUMBER_INT),
                    $_SESSION['user_id'],
                    null

                );
                if ($answer) {
                    echo "<script>alert('Kommentaren ble lagt til');</script>";
                    header("Refresh:0");
                } else {
                    echo "<div class='container mt-4'><p class='text-danger'>Det skjedde en feil. Prøv igjen senere.</p></div>";
                }
            }
        }
        else
        {
            $answer = comment_user(
                filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING),
                filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_NUMBER_INT),
                null,
                null
            );
            if ($answer) {
                echo "<script>alert('Kommentaren ble lagt til');</script>";
                header("Refresh:0");
            } else {
                echo "<div class='container mt-4'><p class='text-danger'>Det skjedde en feil. Prøv igjen senere.</p></div>";
            }
        }
    }
}
