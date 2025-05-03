<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['felhasznalo_id'])) {
    try {
        $dbh = new PDO(
            'mysql:host=127.0.0.1;dbname=barcza17;charset=utf8',
            'barcza17',
            'Nethely_123',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
        

        $filePath = null;
        if (isset($_FILES['kep']) && $_FILES['kep']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($_FILES['kep']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['kep']['tmp_name'], $filePath)) {
                // Kép mentése az adatbázisba
                $sql = "INSERT INTO kepek (fajlnev) VALUES (:fajlnev)";
                $sth = $dbh->prepare($sql);
                $sth->execute([':fajlnev' => $fileName]);
            } else {
                echo "<p>Hiba történt a kép feltöltése során.</p>";
            }
        }
    } catch (PDOException $e) {
        echo "<p>Hiba történt az adatbázis műveletek során: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>