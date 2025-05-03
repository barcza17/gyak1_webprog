<?php
session_start();  
session_unset();        // Törli az összes $_SESSION változót
session_destroy();      // Megsemmisíti a sessiont szerveroldalon

header("Location: ../index.php");
exit();
