<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div style="max-width: 600px; margin: auto; padding: 20px;">
<?php if(isset($row)) { ?>
    <?php if($row) { ?>
        <h1>Bejelentkezett:</h1>
        <p>Azonosító: <strong><?= $row['id'] ?></strong></p>
        <p>Név: <strong><?= $row['csaladi_nev']." ".$row['uto_nev'] ?></strong></p>
    <?php } else { ?>
        <h1>A bejelentkezés nem sikerült!</h1>
        <a href="index.php?page=belepes">Próbálja újra!</a>
    <?php } ?>
<?php } ?>
<?php if(isset($errormessage)) { ?>
    <h2><?= $errormessage ?></h2>
<?php } ?>
</div>

