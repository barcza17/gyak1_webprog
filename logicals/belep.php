<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Bejelentkezés ellenőrzése
if (isset($_POST['felhasznalonev']) && isset($_POST['jelszo'])) {
    try {
        // Kapcsolódás
        $dbh = new PDO(
            'mysql:host=127.0.0.1;dbname=barcza17;charset=utf8',
            'barcza17',
            'Nethely_123',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
        
        
        
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // Felhasználó keresése
        $sqlSelect = "SELECT id, csaladi_nev, uto_nev FROM felhasznalok WHERE felhasznalonev = :felhasznalonev AND jelszo = sha1(:jelszo)";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':felhasznalonev' => $_POST['felhasznalonev'], ':jelszo' => $_POST['jelszo']));
        $row = $sth->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Sikeres bejelentkezés
            $_SESSION['csn'] = $row['csaladi_nev'];
            $_SESSION['un'] = $row['uto_nev'];
            $_SESSION['login'] = $_POST['felhasznalonev'];
            $_SESSION['felhasznalo_id'] = $row['id']; 

            // JavaScript alert és átirányítás
            echo "<script>
            window.location.href = '../index.php';
                alert('Sikeres bejelentkezés!');
            </script>";
        } else {
            // Sikertelen bejelentkezés
            echo "<script>
            window.location.href = '../belepes.tpl.php';
                alert('Sikertelen bejelentkezés!');
            </script>";
            echo "<p>Hibás felhasználónév vagy jelszó!</p>";
        }
    
    } catch (PDOException $e) {
        echo "<p>Hiba történt: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    header("Location: ../index.php"); // Ha nincs POST adat, visszairányítjuk a főoldalra
    echo "<p>Hiba történt: Nincs bejelentkezési adat!</p>";
    exit();
}
?>