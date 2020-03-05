<nav class="navbar">
    <div class="container mt-5">
        <a class='font-weight-bold' href="lecturlogin.php">Innlogging foreleser</a>
        <a class='font-weight-bold' href="lecturregister.php">Registrering foreleser</a>
        <a class='font-weight-bold' href="adminlogin.php">Innlogging administrator</a>
    </div>
</nav>

<?php
require_once "./classes/DatabaseConnection.php";
require_once "./dataaccess/anonym/get_courses.php";

$courses = get_courses();
?>

<div class="container mt-5">
    <h2>Anonyme brukere</h2>
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

