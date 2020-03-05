<?php session_start();

if(!array_key_exists('lectur_id', $_SESSION))
{
    header("Location: index.php");
    return;
}

require_once "dataaccess/lectur/get_messages.php";
require_once "dataaccess/lectur/add_answer.php";
require_once "classes/Validation.php";

$messages = get_messages($_SESSION['lectur_id']);

require_once "header.php";
?>
<div class="container mt-5">
    <a class="btn btn-danger" href="index.php">Tilbake</a>
    <h2 class="mt-3">Nye meldinger</h2>
    <?php
    if(!empty($messages)){
        foreach ($messages as $key => $val){
            echo "<div class='mt-4'>";
            echo "<h4>Melding (ID: {$val['msg_id']}):</h4>";
            echo "<p>{$val['msg']}</p>";
            echo "<h4>Svar</h4>";
            echo "<textarea id='text-{$val['msg_id']}'></textarea><br />";
            echo "<button class='btn btn-primary btnAnswer' onclick='setInputAnswer({$val['msg_id']})' value='{$val['msg_id']}'>Bekreft svar</button>";
            echo "</div>";
        }
    }
    else echo "<li>Fant ingen uleste meldinger</li>";
    ?>

    <form action="" method ="post" id="answerStudent">
        <input id="answer" name="answer" type="hidden" />
        <input id="msg_id" name="msg_id" type="hidden" />
    </form>

    <script>
        function setInputAnswer(val){
            document.getElementById("answer").value = document.getElementById(`text-${val}`).value;
            document.getElementById("msg_id").value = val;
            document.getElementById("answerStudent").submit();
        }
    </script>

</div>

<?php

if(isset($_POST['answer']) && isset($_POST['msg_id']))
{
    $validator = new \classes\Validation();
    $items = array(
        'answer' => array(
            'ruleName' => 'Svaret',
            'required' => true,
            'min' => 2,
            'max' => 300
        ),
        'msg_id' => array(
            'ruleName' => 'ID',
            'required' => true,
            'min' => 1,
            'max' => 11
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
        $answer = add_answer(
                filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING),
                filter_input(INPUT_POST, 'msg_id', FILTER_SANITIZE_NUMBER_INT)

        );
        if($answer)
        {
            echo "<script>alert('Meldingen ble svart');</script>";
            header("Refresh:0");
        }
        else
        {
            echo "<div class='container mt-4'><p class='text-danger'>Det skjedde en feil. Prøv igjen senere.</p></div>";
        }
    }
}

require_once "footer.php"; ?>
