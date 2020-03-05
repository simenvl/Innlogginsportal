<?php

include_once "classes/DatabaseConnection.php";
include_once "dataaccess/student/get_messages.php";
include_once "dataaccess/student/get_comments.php";
include_once "dataaccess/student/get_courses.php";

$messages = get_messages();
$comments = get_comments();
$courses = get_courses();

?>

<div class="container">
    <h1>Chat</h1>
    <div class="row justify-content-md-center">
        <ul id="messages">
            <?php
            foreach ($messages as $key => $val) {
                if ($_SESSION['user_id'] == $val['student']) {
                    echo "<div class='alert alert-primary'>
                    <p class='mb-0'>" . $val['msg'] . "</p>
                  </div>
                  <p> Fra: " . $_SESSION['name'] . "</p>";
                    foreach ($comments as $key2 => $val2) {
                        if ($val2['msg_id'] == $val['msg_id']) {
                            echo "<div class='alert alert-success'>
                    <p class='mb-0'>" . $val2['comment'] . "</p>
                  </div>";
                        }
                    }
                }
            }
            ?>
        </ul>
    </div>
    <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_COMPAT, 'UTF-8'); ?>" method="post">
        <div class="form-group">
            <label>Studieretning</label>
            <select name="course" id="course" class="form-control">
                <?php
                foreach ($courses as $course => $val) {
                    echo "<option value='" . $val['lectur_id'] . "'>" . $val['course_name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="msg" id="msg" class="form-control"/>
        </div>
        <button type="submit" name="sendMessage" class="btn btn-primary">Send</button>
</div>
</form>
</div>