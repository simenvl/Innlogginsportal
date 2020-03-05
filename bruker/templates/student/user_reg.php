<?php
    require_once "header.php";
    require_once "./classes/DatabaseConnection.php";
    require_once "./dataaccess/student/get_courses.php";

    $courses = get_courses();

    ?>

<section class="login">
    <h1>Bruker registrering</h1>
    <form action="" method="post">
        <div class="form-body">
            <div class="form-group">
                <label>Navn</label>
                <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Ditt navn">
            </div>
            <div class="form-group">
                <label>Passord</label>
                <input type="password" name="user_password" class="form-control" id="user_password" placeholder="Passord">
            </div>
            <div class="form-group">
                <label>E-post</label>
                <input type="email" name="user_email" class="form-control" id="user_email" placeholder="E-post">
            </div>
            <div class="form-group">
                <label>Studieretning</label>
                <select name="user_course" id="user_course" class="form-control">
                    <?php
                    foreach ($courses as $key => $val) {
                      echo "<option value='" .
                        $val['id'] .
                        "'>" .
                        $val['course_name'] .
                        "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Kull</label>
                <input type="text" name="user_year" class="form-control" id="user_year" placeholder="Kull">
            </div>
        </div>
        <button type="submit" name="registerUser" class="btn btn-primary">Registrer</button>
        <a href="index.php" class="btn btn-danger">Tilbake</a>
    </form>

    <div class="loginbtn">
        <a href="userlogin.php">Allerede bruker?</a>
    </div>
</section>