<?php session_start();

if(!array_key_exists('lectur_id', $_SESSION))
{
    header("Location: index.php");
    return;
}

require_once "./classes/Validation.php";
require_once "./dataaccess/lectur/add_course.php";
require_once "./dataaccess/lectur/get_courses.php";
require_once "header.php";

$courses = get_courses($_SESSION['lectur_id']);

?>

<div class="container mt-2">
    <h2>Dine emner</h2>
    <ul>
        <?php
        if(!empty($courses)){
            foreach($courses as $key => $val){
                echo "<li>({$val['course_code']}) {$val['course_name']}</li>";
            }
        } else echo "<li>Du har ingen emner</li>";
        ?>
    </ul>
</div>

<div class="container">
    <h2>Registrer emner</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="course_code">Emnekode</label>
            <input name="course_code" type="text" class="form-control" id="course_code" placeholder="Emnekode">
        </div>
        <div class="form-group">
            <label for="course_name">Emnenavn</label>
            <input name="course_name" type="text" class="form-control" id="course_name" placeholder="Emnenavn">
        </div>
        <div class="form-group">
            <label for="pin_code">Pinkode</label>
            <input name="pin_code" type="number" min="1000" max="9999" class="form-control" id="pin_code" placeholder="Pinkode">
        </div>
        <button type="submit" name="addCourse" class="btn btn-primary">Legg til emne</button>
        <a href="index.php" class="btn btn-danger">Tilbake</a>
    </form>
</div>

<?php

if(isset($_POST['addCourse'])){
    $validator = new \classes\Validation();
    $items = array(
        'course_code' => array(
            'ruleName' => 'Emnekode',
            'required' => true,
            'min' => 5,
            'max' => 10
        ),
        'course_name' => array(
            'ruleName' => 'Emnenavn',
            'required' => true,
            'min' => 2,
            'max' => 60
        ),
        'pin_code' => array(
            'ruleName' => 'Pinkode',
            'required' => true,
            'min' => 4,
            'max' => 4
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
        $added = add_course(
            filter_input(INPUT_POST, 'course_code', FILTER_SANITIZE_STRING),
            filter_input(INPUT_POST, 'course_name', FILTER_SANITIZE_STRING),
            $_SESSION['lectur_id'],
            filter_input(INPUT_POST, 'pin_code', FILTER_SANITIZE_NUMBER_INT)
        );

        if($added)
        {
            echo "<script>alert('Emnet ble lagt til')</script>";
            header("Refresh:0");
        }
        else
        {
            echo "<div class='container mt-4'><p class='text-danger'>Kunne ikke legge deg til i emnet. Mulige årsaker: Emnet er allerede registrert på noen andre?</p></div>";
        }
    }
}

require_once "footer.php";

?>


