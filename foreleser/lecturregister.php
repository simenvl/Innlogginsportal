<?php session_start();

if(array_key_exists('logged_in', $_SESSION))
{
    if($_SESSION['logged_in'] == true)
    {
        header("Location: index.php");
        return;
    }
}

require_once "header.php";

require_once "./templates/lectur/lectur_reg.php";
require_once "image_handler.php";
require_once "./classes/Validation.php";
require_once "./dataaccess/lectur/add_lectur.php";
require_once "./crypt.php";


if(isset($_POST['registerLecturer']))
{
    if(!empty($_FILES['lectur_img']['name']))
    {
        $is_allowed = allowed_file($_FILES['lectur_img']['type'], $_FILES['lectur_img']['size']);

        if($is_allowed)
        {
            $validator = new \classes\Validation();
            $items = array(
                'lectur_fname' => array(
                    'ruleName' => 'Fornavn',
                    'required' => true,
                    'min' => 2,
                    'max' => 60
                ),
                'lectur_lname' => array(
                    'ruleName' => 'Etternavn',
                    'required' => true,
                    'min' => 2,
                    'max' => 60
                ),
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
                $file_uploaded = upload_file($_FILES['lectur_img']['name'], $_FILES['lectur_img']['tmp_name']);
                if($file_uploaded)
                {
                    $user_added = add_lectur(
                        filter_input(INPUT_POST, 'lectur_fname', FILTER_SANITIZE_STRING),
                        filter_input(INPUT_POST, 'lectur_lname', FILTER_SANITIZE_STRING),
                        filter_input(INPUT_POST, 'lectur_email', FILTER_SANITIZE_STRING),
                        crypt_pw(filter_input(INPUT_POST, 'lectur_password', FILTER_SANITIZE_STRING)),
                        filter_var($_FILES['lectur_img']['name'], FILTER_SANITIZE_STRING)
                    );
                    if($user_added)
                    {
                        echo "<script>
                                    alert('Kontoen har blitt registrert. Vent på aktivering fra administrator.');
                                    window.location.href='index.php';
                              </script>";
                    }
                    else
                    {
                        echo "<div class='container'><p class='alert-danger mt-4'>Det skjedde en feil. Prøv igjen senere.</p></div>";
                        unlink("uploads/{$_FILES['lectur_img']['name']}");
                    }
                }
                else
                {
                    echo "<div class='container'><p class='alert-danger mt-4'>Kunne ikke laste opp filen.</p></div>";
                }
            }
        }
        else
        {
            echo "<div class='container'><p class='alert-danger mt-4'>Filtypen er ugyldig eller for stor.</p></div>";
        }
    }
    else
    {
        echo "<div class='container'><p class='alert-danger mt-4'>Last opp et bilde.</p></div>";
    }
}


require_once "footer.php";