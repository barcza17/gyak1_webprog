<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $dbh = new PDO(
        'mysql:host=127.0.0.1;dbname=barcza17;charset=utf8',
        'barcza17',
        'Nethely_123',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
    
    

    $sql = "SELECT kapcsolatfelvetel.uzenet, kapcsolatfelvetel.kuldes_ideje, 
                   IFNULL(felhasznalok.felhasznalonev, 'Vendég') AS kuldo
            FROM kapcsolatfelvetel
            LEFT JOIN felhasznalok ON kapcsolatfelvetel.felhasznalo_id = felhasznalok.id
            ORDER BY kapcsolatfelvetel.kuldes_ideje DESC";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $uzenetek = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Hiba történt az adatbázis műveletek során: ' . htmlspecialchars($e->getMessage()));
}
?>

<div class="uzenetek-container">
    <h2>Kapott üzenetek</h2>
    <table>
        <thead>
            <tr>
                <th>Küldő</th>
                <th>Üzenet</th>
                <th>Küldés ideje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($uzenetek as $uzenet) { ?>
                <tr>
                    <td><?= htmlspecialchars($uzenet['kuldo']) ?></td>
                    <td><?= htmlspecialchars($uzenet['uzenet']) ?></td>
                    <td><?= htmlspecialchars($uzenet['kuldes_ideje']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
