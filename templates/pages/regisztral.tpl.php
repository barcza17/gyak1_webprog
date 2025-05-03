<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="./styles/stilus.css" type="text/css">
</head>
<body>
    <div id="content">
        <?php if (isset($uzenet)) { ?>
            <h1><?= $uzenet ?></h1>
            <?php if ($ujra) { ?>
                <p><a href="belepes" class="button-link">Próbálja újra!</a></p>
            <?php } ?>
        <?php } ?>
    </div>
</body>
</html>

