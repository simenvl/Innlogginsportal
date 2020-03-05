<?php

include_once "classes/DatabaseConnection.php";
include_once "dataaccess/student/get_messages.php";
include_once "dataaccess/student/get_comments.php";
include_once "dataaccess/student/get_courses.php";

$messages = get_messages($_SESSION['user_id']);
$comments = get_comments();
$courses = get_courses();

?>

<div class="container">
    <h1>Chat</h1>
    <div class="row justify-content-md-center">
        <ul id="messages">
            <?php
            foreach ($messages as $key => $val) {
                    echo "
                  <p><strong>Melding: </strong></p>
                  <div class='alert alert-primary'>
                            <p class='mb-0'>" . $val['msg'] . "</p>
                  </div>
                  <p> Fra: " . $_SESSION['name'] . "</p>";
                    if ($val['answer'] == null) {
                        echo "";
                    } else {
                        echo "                  
                             <p><strong>Svar:</strong></p>
                             <div class='alert alert-success'>
                                <p class='mb-0'>" . $val['answer'] . "</p>
                             </div>";
                    }
            }
            ?>
        </ul>
    </div>
    <div class="container">
        <img class="img-fluid w-25" id="img" src="">
    </div>
    <form action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_COMPAT, 'UTF-8'); ?>" method="post">
        <div class="form-group">
            <label>Studieretning</label>
            <select name="lectur" id="lectur" class="form-control">
                <?php
                foreach ($courses as $course => $val) {
                    echo "<option value='" . $val['lectur_id'] . "'>" . $val['course_name'] . "</option>";
                }
                echo "<input type='hidden' name='course_id' value='" . $val['id'] . "'>";
                ?>
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="msg" id="msg" class="form-control"/>
        </div>
        <button type="submit" name="sendMessage" class="btn btn-primary">Send</button>
</form>
    <span id="test"></span>
</div>
<script>
    function loadImg(id) {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(id);
                let res = JSON.parse(this.responseText);
                let img = Object.values(res).toString();
                console.log(img);
                document.getElementById("img").src = "http://158.39.188.214/foreleser/uploads/" + img;
            }
        };
        xhttp.open("GET", "http://158.39.188.214/foreleser/api/student/image.php?lectur_id=" + id, true);
        xhttp.send();
    }

    const select = document.getElementById("lectur");
    const val = select.options[select.selectedIndex].value;
    loadImg(val);

    select.onchange = (e) => loadImg(e.target.value);

</script>