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
require_once "./classes/Validation.php";
require_once "./dataaccess/admin/verify_admin.php";

?>
    <div class="container mt-5">
        <form action="" method="post">
            <div class="form-group">
                <label for="admin">Brukernavn</label>
                <input name="admin" type="text" class="form-control" id="admin" placeholder="Brukernavn">
            </div>
            <div class="form-group">
                <label for="admin_password">Passord</label>
                <input name="admin_password" type="password" class="form-control" id="admin_password" placeholder="Passord">
            </div>
            <button type="submit" name="loginAdmin" class="btn btn-primary">Logg inn</button>
            <a href="index.php" class="btn btn-danger">Tilbake</a>
        </form>
    </div>

<?php

if(isset($_POST['loginAdmin'])){
    $validator = new \classes\Validation();
    $items = array(
        'admin' => array(
            'ruleName' => 'Brukernavn',
            'required' => true,
            'max' => 60
        ),
        'admin_password' => array(
            'ruleName' => 'Passord',
            'required' => true,
            'min' => 5,
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
        if(verify_admin(
            filter_input(INPUT_POST, 'admin', FILTER_SANITIZE_STRING),
            filter_input(INPUT_POST, 'admin_password', FILTER_SANITIZE_STRING))
        )
        {
            header('Location: index.php');
        }
        else
        {
            echo "<div class='container mt-4'><p class='text-danger'>Brukernavn og/eller passordet er feil.</p></div>";
        }
    }
}


require_once "footer.php"; ?>