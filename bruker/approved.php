<?php
require "functions.php";
$name = mysqli_real_escape_string($db, $_POST['name']);
$password = mysqli_real_escape_string($db, $_POST['password']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$course = mysqli_real_escape_string($db, $_POST['course']);
$year = mysqli_real_escape_string($db, $_POST['year']);

$sql_post = "INSERT INTO student (name, password, email, course, year)
        VALUES ('$name', '$password', '$email','$course','$year')";

mysqli_query($db, $sql_post);
?>

<div class="approved text-center">
    <p>Takk for din tilbakemelding, vi setter utrolig pris på den.</p>
    <a href="registeruser.php">Lukk</a>
</div>