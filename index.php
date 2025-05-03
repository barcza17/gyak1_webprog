
<?php
    include('./includes/config.inc.php');

    $page = $_GET['page'] ?? '/';

    if (isset($oldalak[$page]) && file_exists("./templates/pages/{$oldalak[$page]['fajl']}.tpl.php")) {
        $keres = $oldalak[$page];

       
        if (file_exists("logicals/{$keres['fajl']}.php")) {
            include_once("logicals/{$keres['fajl']}.php");
        }

    } else {
        $keres = $hiba_oldal;
        header("HTTP/1.0 404 Not Found");
    }

    include('./templates/index.tpl.php');
?>
