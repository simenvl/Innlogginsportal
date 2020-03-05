<?php
require_once "dataaccess/student/change_password_user.php";
require_once "classes/validation.php";
require_once "crypt.php";
?>

    <div class="container">
        <h1>Hei <?php echo $_SESSION['name']; ?></h1>
            <a class="btn btn-primary" href="logout.php">Logg ut</a><br/>
    </div>

<?php
require_once 'templates/change_password.php';
require_once "chat.php";



if(isset($_POST['changePassword']))
{
    $validator = new \classes\Validation();
    $items = array(
        'old_password' => array(
            'ruleName' => 'Gammelt passord',
            'required' => true,
            'min' => 6,
            'max' => 20
        ),
        'new_password' => array(
            'ruleName' => 'Nytt passord',
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
        $changed = change_password_user(
            (int) $_SESSION['user_id'],
            filter_input(INPUT_POST, 'old_password', FILTER_SANITIZE_STRING),
            crypt_pw(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING))
        );

        if($changed)
        {
            echo "<script>alert('Passordet ble endret.');</script>";
        }
    }
}

?>