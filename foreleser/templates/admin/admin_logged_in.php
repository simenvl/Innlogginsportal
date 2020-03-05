<?php
require_once "./dataaccess/admin/active_users.php";

$lecturers = active_users('select lectur_id, fname, lname from lecturers where active = 1');

?>
<div class="container mt-5">
    <h1>Hei <?php echo $_SESSION['username']; ?></h1>
    <nav>
        <a class="btn btn-primary" href="logout.php">Logg ut</a><br/>
        <a class="" href="confirm.php">Bekreft brukere/forelesere</a>
    </nav>
</div>

<div class="container mt-4">
    <h2 class="mt-5">Aktive forelesere</h2>
    <ul>
    <?php
    if(!empty($lecturers)){
        foreach ($lecturers as $key => $val){
            echo "<li>(ID: {$val['lectur_id']}) {$val['fname']} {$val['lname']} </li>";
        }
    } else echo "<li>Ingen aktive forelesere.</li>" ?>
    </ul>

</div>
