<?php session_start();

if(!array_key_exists('admin_id', $_SESSION))
{
    header("Location: index.php");
    return;
}

require_once "./dataaccess/admin/active_users.php";
require_once "./dataaccess/admin/activate_users.php";

$lectures = active_users('select lectur_id, fname, lname from lecturers where active IS NULL');

require_once "header.php";
?>

<div class="container mt-5">
    <a class="btn btn-danger" href="index.php">Tilbake</a>
    <h2 class="mt-3">Inaktive forelesere</h2>
        <ul>
            <?php
            if(!empty($lectures)){
                foreach ($lectures as $key => $val){
                    echo "<li>
                            (ID: {$val['lectur_id']}) {$val['fname']} {$val['lname']}
                            <button class='btn btn-primary btnActivateLecturer' value='{$val['lectur_id']}' type='button'>Aktiver konto</button>
                          </li>";
                }
            }
            else echo "<li>Fant ingen inaktive forelesere</li>";
            ?>
        </ul>
</div>

<form action="" method ="post" id="activateLecturer">
    <input id="lectur_id" name="lectur_id" type="hidden" />
</form>


<script>
    document.querySelector(".btnActivateLecturer").addEventListener('click', setInputLecturer);

    function setInputLecturer(event){
        document.getElementById("lectur_id").value = event.target.value;
        document.getElementById("activateLecturer").submit();
    }
</script>

<?php

if(isset($_POST['lectur_id'])){

    if(filter_var($_POST['lectur_id'], FILTER_VALIDATE_INT))
    {
        $activated = activate_users($_POST['lectur_id']);
        if($activated)
        {
            echo "<script>alert('Foreleseren ble aktivert.')</script>";
            header("Refresh:0");
        }
        else
        {
            echo "<div class='container mt-4'><p class='text-danger'>Det skjedde en feil. Prøv igjen senere.</p></div>";
        }
    }
    else
    {
        echo "<div class='container mt-4'><p class='text-danger'>Det skjedde en feil. Prøv igjen senere.</p></div>";
    }
}


require_once "footer.php"; ?>

