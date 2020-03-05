<?php ;

session_start();

if (array_key_exists('logged_in', $_SESSION)) {
  if ($_SESSION['logged_in'] == true) {
    header("Location: index.php");
  }
}

require_once "header.php";

require_once "./templates/student/user_reg.php";
require_once "./classes/validation.php";
require_once "./dataaccess/student/add_user.php";
require_once "./crypt.php";


if (isset($_POST['registerUser'])) {

    $validator = new classes\Validation();
    $items = array(
        'user_name' => array(
            'ruleName' => 'Navn',
            'required' => true,
            'min' => 2,
            'max' => 60
        ),
        'user_password' => array(
            'ruleName' => 'Passord',
            'required' => true,
            'min' => 6,
            'max' => 60
        ),
        'user_email' => array(
            'ruleName' => 'E-postadresse',
            'required' => true,
            'emailVerify' => $_POST['user_email'],
            'max' => 120
        ),
        'user_course' => array(
            'ruleName' => 'Studie',
            'required' => true,
            'min' => 1,
            'max' => 20
        ),
        'user_year' => array(
            'ruleName' => 'Kull',
            'required' => true,
            'min' => 4,
            'max' => 4
        )
    );

    $inputValidation = $validator->checkUserInput($_POST, $items);

    if (!$inputValidation->getPassed()) {
        foreach ($inputValidation->getErrors() as $key => $val) {
            echo "<div class='container mt-4'><p class='text-danger'> {$val}</p></div>";
        }
    } else {
        $user_added = add_user(
            filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_STRING),
            crypt_pw(
                filter_input(
                    INPUT_POST,
                    'user_password',
                    FILTER_SANITIZE_STRING
                )
            ),
            filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_STRING),
            filter_input(INPUT_POST, 'user_course', FILTER_SANITIZE_NUMBER_INT),
            filter_input(INPUT_POST, 'user_year', FILTER_SANITIZE_NUMBER_INT)
        );
        if ($user_added) {
            header('Location: ./userlogin.php');
        } else {
            echo "<div class='container'><p class='alert-danger mt-4'>Det skjedde en feil. Prøv igjen senere.</p></div>";
        }
    }
}

require "footer.php";
