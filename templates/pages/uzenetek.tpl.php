<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Kapcsolódás az adatbázishoz
    $dbh = new PDO('mysql:host=localhost;dbname=receptek_users', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

    // Táblák létrehozása, ha nem léteznek
    $dbh->exec("
        CREATE TABLE IF NOT EXISTS felhasznalok (
            id INT AUTO_INCREMENT PRIMARY KEY,
            bejelentkezes VARCHAR(50) NOT NULL,
            jelszo VARCHAR(255) NOT NULL,
            csaladi_nev VARCHAR(50) NOT NULL,
            uto_nev VARCHAR(50) NOT NULL
        )
    ");

    $dbh->exec("
        CREATE TABLE IF NOT EXISTS uzenetek (
            id INT AUTO_INCREMENT PRIMARY KEY,
            uzenet TEXT NOT NULL,
            kuldes_ideje DATETIME NOT NULL,
            felhasznalo_id INT NULL,
            FOREIGN KEY (felhasznalo_id) REFERENCES felhasznalok(id) ON DELETE SET NULL
        )
    ");

   // Üzenet mentése az adatbázisba
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uzenet']) && !empty(trim($_POST['uzenet']))) {
    $uzenet = trim($_POST['uzenet']);
    $felhasznalo_id = isset($_SESSION['felhasznalo_id']) ? $_SESSION['felhasznalo_id'] : null;

    $sql = "INSERT INTO uzenetek (uzenet, kuldes_ideje, felhasznalo_id) VALUES (:uzenet, NOW(), :felhasznalo_id)";
    $sth = $dbh->prepare($sql);
    $sth->execute([
        ':uzenet' => $uzenet,
        ':felhasznalo_id' => $felhasznalo_id
    ]);

    // JavaScript alert a sikeres üzenetküldés után
    echo "<script>alert('Üzenet sikeresen elküldve!');</script>";
}

    // Üzenetek lekérdezése fordított időrendben
    $sql = "SELECT uzenetek.uzenet, uzenetek.kuldes_ideje, 
                   IFNULL(felhasznalok.felhasznalonev, 'Vendég') AS kuldo
            FROM uzenetek
            LEFT JOIN felhasznalok ON uzenetek.felhasznalo_id = felhasznalok.id
            ORDER BY uzenetek.kuldes_ideje DESC";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $uzenetek = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Hiba történt az adatbázis műveletek során: " . htmlspecialchars($e->getMessage()) . "</p>";
    return;
}
?>

<div class="uzenetek-container">
    <h2>Üzenetek</h2>

    <form method="post" action="" style="margin-bottom: 20px;">
        <label for="uzenet">Üzenet:</label><br>
        <textarea id="uzenet" name="uzenet" required style="width: 100%; resize: none;"></textarea><br>
        <button type="submit" style="padding: 10px 20px; font-size: 1rem;">Küldés</button>
    </form>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Küldő</th>
                    <th>Üzenet</th>
                    <th>Küldés ideje</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($uzenetek)) { ?>
                    <?php foreach ($uzenetek as $uzenet) { ?>
                        <tr>
                            <td><?= htmlspecialchars($uzenet['kuldo']) ?></td>
                            <td><?= htmlspecialchars($uzenet['uzenet']) ?></td>
                            <td><?= htmlspecialchars($uzenet['kuldes_ideje']) ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3">Nincs megjeleníthető üzenet.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
