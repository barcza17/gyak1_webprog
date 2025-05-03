<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();

    try {
        $dbh = new PDO(
            'mysql:host=127.0.0.1;dbname=barcza17;charset=utf8',
            'barcza17',
            'Nethely_123',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );

        $uzenet = trim($_POST['uzenet'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $felhasznalo_id = $_SESSION['user_id'] ?? null;

        if ($uzenet && $email) {
            $stmt = $dbh->prepare("
                INSERT INTO kapcsolatfelvetel (felhasznalo_id, email, kuldes_ideje, uzenet)
                VALUES (?, ?, NOW(), ?)
            ");
            $stmt->execute([$felhasznalo_id, $email, $uzenet]);

            header("Location: index.php?page=kapcsolat_koszonjuk");
            exit;
        } else {
            echo "Hiányzó mezők: kérjük, töltsd ki az űrlapot!";
        }

    } catch (PDOException $e) {
        die("Adatbázis hiba: " . htmlspecialchars($e->getMessage()));
    }
}
?>
