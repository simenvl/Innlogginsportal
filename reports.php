<?php session_start();

require_once "./dataaccess/anonym/get_single_course.php";
require_once "./dataaccess/anonym/get_messages_answers.php";
require_once "./dataaccess/anonym/report_user.php";

if(!isset($_POST['btnReports']) || empty($_POST['courses']) || empty($_POST['pin_code']))
{
    header("Location: index.php");
    return;
}

$course = get_single_course(filter_input(INPUT_POST, "courses", FILTER_SANITIZE_NUMBER_INT));
$pin = filter_input(INPUT_POST, "pin_code", FILTER_SANITIZE_NUMBER_INT);

if(!$course['pin_code'] == $pin){
    header("Location: index.php");
    return;
}

require_once "header.php";

$msg_ans = get_messages_answers($course['id']);
?>

<div class="container">
    <?php
    if(array_key_exists('logged_in', $_SESSION)){
        if($_SESSION['logged_in'] == true && array_key_exists('lectur_id', $_SESSION)){
            echo "<h1>Hei {$_SESSION['fname']}</h1>";
        } else if($_SESSION['logged_in'] == true && array_key_exists('user_id', $_SESSION)){
            echo "<h1>Hei {$_SESSION['name']}</h1>";
        }
    }
    ?>
    <h3 class="mb-5">Meldinger i emnet <?php echo "({$course['course_code']}) {$course['course_name']}"; ?></h3>
    <?php
    foreach($msg_ans as $key => $val)
    {
        echo "<h5 class='mt-5'>Melding ({$val['msg_id']}): {$val['msg']}</h5>";
        echo "<h5>Svar ({$val['msg_id']}): {$val['answer']}</h5>";
        echo "<h6>Rapporter:</h6>";
        echo "<textarea id='text-{$val['msg_id']}'></textarea><br />";
        echo "<button class='btn btn-primary btnAnswer' onclick='setInputAnswer({$val['msg_id']})' value='{$val['msg_id']}'>Rapporter student</button><br/><br/><br/>";
        echo "<h6>Kommenter:</h6>";
        echo "<textarea id='comment-{$val['msg_id']}'></textarea><br />";
        echo "<button class='btn btn-primary btnAnswer' onclick='setInputComment({$val['msg_id']})' value='{$val['msg_id']}'>Legg til kommentar</button>";
    }
    ?>

    <form action="foreleser/reported.php" method ="post" id="reportStudent">
        <input id="answer" name="answer" type="hidden" />
        <input id="msg_id" name="msg_id" type="hidden" />

    </form>

    <form action="foreleser/commented.php" method ="post" id="commentStudent">
        <input id="comment" name="comment" type="hidden" />
        <input id="message_id" name="message_id" type="hidden" />
    </form>

    <script>
        function setInputAnswer(val){
            document.getElementById("answer").value = document.getElementById(`text-${val}`).value;
            document.getElementById("msg_id").value = val;
            document.getElementById("reportStudent").submit();
        }

        function setInputComment(val){
            document.getElementById("comment").value = document.getElementById(`comment-${val}`).value;
            document.getElementById("message_id").value = val;
            document.getElementById("commentStudent").submit();
        }
    </script>
</div>

<?php

require_once "footer.php";
?>