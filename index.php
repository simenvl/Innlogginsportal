<?php

include_once "header.php";




?>
<body>
    <section class="login">
        <h1>Login</h1>
        <div class="loginbtn">
            <a href="bruker/userlogin.php">Student</a>
            <a href="foreleser/lecturlogin.php">Forelser</a>
            <a href="foreleser/adminlogin.php">Admin</a>
        </div>
        <h1>Registrer</h1>
        <div class="loginbtn">
            <a href="bruker/registeruser.php">Student</a>
            <a href="foreleser/lecturregister.php">Foreleser</a>
        </div>
    </section>
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
    <?php include_once "footer.php";?>
