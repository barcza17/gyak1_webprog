<!DOCTYPE html>
<html>
<head>
    <title>Regisztráció</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

    <body>
        <?php if(isset($uzenet)) { ?>
            <h1><?= $uzenet ?></h1>
            <?php if($ujra) { ?>
                <a href="belepes">Próbálja újra!</a>
            <?php } ?>
        <?php } ?>
    </body>  
