<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (
    isset($_POST['felhasznalo']) &&
    isset($_POST['jelszo']) &&
    isset($_POST['vezeteknev']) &&
    isset($_POST['utonev'])
) {
    try {
        $dbh = new PDO(
            'mysql:host=127.0.0.1;dbname=barcza17;charset=utf8',
            'barcza17',
            'Nethely_123',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

        $sqlSelect = "SELECT id FROM felhasznalok WHERE felhasznalonev = :felhasznalonev";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute([':felhasznalonev' => $_POST['felhasznalo']]);

        if ($sth->fetch(PDO::FETCH_ASSOC)) {
            echo "<script>
                alert('A felhasználónév már foglalt!');
                window.history.back();
            </script>";
            exit();
        } else {
            $sqlInsert = "INSERT INTO felhasznalok (csaladi_nev, uto_nev, felhasznalonev, jelszo)
                          VALUES (:csaladinev, :utonev, :felhasznalonev, :jelszo)";
            $stmt = $dbh->prepare($sqlInsert);
            $stmt->execute([
                ':csaladinev' => $_POST['vezeteknev'],
                ':utonev' => $_POST['utonev'],
                ':felhasznalonev' => $_POST['felhasznalo'],
                ':jelszo' => sha1($_POST['jelszo'])
            ]);

            if ($stmt->rowCount()) {
                // Sikeres regisztráció
                header("Location: ../index.php?page=belepes&siker=1");

            } else {
                // Sikertelen
                header("Location: ../index.php?page=belepes&hiba=1");

            }
            
        }
    } catch (PDOException $e) {
        header("Location: ../belepes.tpl.php?hiba=2");
        exit();
    }
    
} else {
    header("Location: ../belepes.tpl.php");
    exit();
}
?>
