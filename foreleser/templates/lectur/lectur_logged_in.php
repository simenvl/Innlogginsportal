<?php
require_once "./dataaccess/lectur/change_password_lectur.php";
require_once "classes/Validation.php";
require_once "crypt.php";
?>

<div class="container">
    <h1>Hei <?php echo $_SESSION['fname']; ?></h1>
    <nav>
        <a class="btn btn-primary" href="logout.php">Logg ut</a><br/>
        <a href="courses.php">Emner</a>
        <a href="messages.php">Meldinger</a>
    </nav>
</div>



<?php require_once 'templates/change_password.php';

    require_once "./classes/DatabaseConnection.php";
    require_once "./dataaccess/anonym/get_courses.php";

    $courses = get_courses();
    ?>

    <div class="container mt-5">
        <h2>Meldiger i forskjellige emner</h2>
        <h3>Velg emne:</h3>
        <form action="reports.php" method="post">
            <select id="courses" name="courses">
                <?php
                foreach ($courses as $key => $val){
                    echo "<option value='{$val['id']}'>({$val['course_code']}) {$val['course_name']}</option>";
                }
                ?>
            </select>
            <div class="form-group">
                <label for="pin_code">Pinkode</label>
                <input name="pin_code" type="number" min="1000" max="9999" class="form-control" id="pin_code" placeholder="Pinkode">
            </div>
            <button type="submit" name="btnReports" class="btn btn-primary">Kjør</button>
        </form>
    </div>

<?php

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
        $changed = change_password_lectur(
                (int) $_SESSION['lectur_id'],
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