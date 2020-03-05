<?php
    require_once "header.php";
    require_once "./classes/DatabaseConnection.php";
    require_once "./dataaccess/student/get_courses.php";

    $courses = get_courses();

    ?>

<section class="login">
    <h1>Bruker registrering</h1>
    <!--<form action="approved.php" method="post">-->
    <form action="" method="post">
        <div class="form-body">
            <div class="form-group">
                <label>Navn</label>
                <input type="text" name="name" placeholder="Ditt navn" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Passord</label>
                <input type="password" name="password" placeholder="Passord" class="form-control" required>
            </div>
            <div class="form-group">
                <label>E-post</label>
                <input type="email" name="email" placeholder="E-post" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Studieretning</label>
                <select name="course" id="course" class="form-control">
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
                <input type="text" name="year" placeholder="Kull" class="form-control" required>
            </div>
        </div>
        <input id="submitForm" type="submit" value="Registrer" name="submit" class="btn btn-primary mb-2"></input>
    </form>

    <div class="loginbtn">
        <a href="userlogin.php">Allerede bruker?</a>
    </div>
</section>


</body>

</html>