<?php session_start();

if(array_key_exists('logged_in', $_SESSION))
{
    if($_SESSION['logged_in'] == true)
    {
        header("Location: index.php");
        return;
    }
}

require_once "./classes/Validation.php";
require_once "./dataaccess/lectur/verify_lectur.php";
require_once "./templates/lectur/lectur_login.php";

require_once "header.php";


if(isset($_POST['loginLecturer'])){
    $validator = new \classes\Validation();
    $items = array(
        'lectur_email' => array(
            'ruleName' => 'E-postadresse',
            'required' => true,
            'emailVerify' => $_POST['lectur_email'],
            'max' => 120
        ),
        'lectur_password' => array(
            'ruleName' => 'Passord',
            'required' => true,
            'min' => 6,
            'max' => 20
        )
    );

    $inputValidation = $validator->checkUserInput($_POST, $items);

    if(!$inputValidation->getPassed())
    {
        foreach($inputValidation->getErrors() as $key => $val)
        {
            echo "<div class='container mt-4'><p class='text-danger'> {$val}</p></div>";
        }
    }
    else
    {
        if(verify_lectur(
            filter_input(INPUT_POST, 'lectur_email', FILTER_SANITIZE_STRING),
            filter_input(INPUT_POST, 'lectur_password', FILTER_SANITIZE_STRING))
        )
        {
            header('Location: index.php');
        }
        else
        {
            echo "<div class='container mt-4'>
                    <p class='text-danger'>Kunne ikke logge inn. Mulige årsaker:</p>
                    <p class='text-danger'>Brukernavn og/eller passordet er feil.</p>
                    <p class='text-danger'>Kontoen har ikke blitt aktivert.</p>
                </div>";
        }
    }
}


require_once "footer.php";

