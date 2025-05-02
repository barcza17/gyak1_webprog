<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();

    // Kapcsolódás az adatbázishoz
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=receptek_users', 'root', '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $uzenet = trim($_POST['uzenet'] ?? '');

        if ($uzenet) {
            $felhasznalo_id = $_SESSION['user_id'] ?? null;

            $stmt = $dbh->prepare("INSERT INTO kapcsolatfelvetel (uzenet, kuldes_ideje, felhasznalo_id) VALUES (?, NOW(), ?)");
            $stmt->execute([$uzenet, $felhasznalo_id]);
        }

        header("Location: index.php?page=kapcsolat_koszonjuk");
        exit;
    } catch (PDOException $e) {
        die("Hiba: " . htmlspecialchars($e->getMessage()));
    }
}
?>
