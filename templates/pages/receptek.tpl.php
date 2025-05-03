<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $fileName = basename($_FILES['kep']['name']);
            $filePath = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES['kep']['tmp_name'], $filePath)) {
                echo "<script>alert('Hiba történt a kép feltöltése során.');</script>";
                $filePath = null;
            }
        }

        $sql = "INSERT INTO receptek (nev, hozzavalok, lepesek, kep) VALUES (:nev, :hozzavalok, :lepesek, :kep)";
        $sth = $dbh->prepare($sql);
        $sth->execute([
            ':nev' => $_POST['nev'],
            ':hozzavalok' => $_POST['hozzavalok'],
            ':lepesek' => $_POST['lepesek'],
            ':kep' => $filePath
        ]);

        echo "<script>alert('Recept sikeresen hozzáadva!');</script>";
    } catch (PDOException $e) {
        echo "<p>Hiba történt az adatbázis műveletek során: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
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
    $sql = "SELECT * FROM receptek ORDER BY id DESC";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $receptek = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Hiba történt az adatbázis műveletek során: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<div class="receptek-container">
    <h1>Receptjeink</h1>

    <button class="add-recipe-button" onclick="openAddRecipeModal()">Recept hozzáadása</button>

    <?php if (!empty($receptek)) { ?>
        <ul class="recipe-list">
            <?php foreach ($receptek as $recept) { ?>
                <li>
                    <a href="#" class="recipe-link" onclick="openRecipeModal(<?= htmlspecialchars(json_encode($recept)) ?>)">
                        <?= htmlspecialchars($recept['nev']) ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p class="no-recipes-message">Jelenleg nincs megjeleníthető recept.</p>
    <?php } ?>
</div>

<div class="modal" id="addRecipeModal">
    <div class="modal-header">
        <h2>Új recept hozzáadása</h2>
        <button class="close-button" onclick="closeAddRecipeModal()">&times;</button>
    </div>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="text" name="nev" placeholder="Recept neve" required>
        <textarea name="hozzavalok" placeholder="Hozzávalók" rows="5" required></textarea>
        <textarea name="lepesek" placeholder="Lépések" rows="5" required></textarea>
        <input type="file" name="kep" accept="image/*">
        <button type="submit">Mentés</button>
    </form>
</div>

<div class="modal" id="viewRecipeModal">
    <div class="modal-header">
        <h2 id="recipeTitle"></h2>
        <button class="close-button" onclick="closeRecipeModal()">&times;</button>
    </div>
    <div class="modal-content">
        <p><strong>Hozzávalók:</strong></p>
        <p id="recipeIngredients"></p>
        <p><strong>Lépések:</strong></p>
        <p id="recipeSteps"></p>
        <div id="recipeImageContainer"></div>
    </div>
</div>

<div class="overlay" id="overlay" onclick="closeAllModals()"></div>

<script>
    function openAddRecipeModal() {
        document.getElementById('addRecipeModal').classList.add('active');
        document.getElementById('overlay').classList.add('active');
    }

    function closeAddRecipeModal() {
        document.getElementById('addRecipeModal').classList.remove('active');
        document.getElementById('overlay').classList.remove('active');
    }

    function openRecipeModal(recept) {
        document.getElementById('recipeTitle').textContent = recept.nev;
        document.getElementById('recipeIngredients').textContent = recept.hozzavalok;
        document.getElementById('recipeSteps').textContent = recept.lepesek;

        const imageContainer = document.getElementById('recipeImageContainer');
        imageContainer.innerHTML = '';
        if (recept.kep) {
            const img = document.createElement('img');
            img.src = recept.kep;
            img.alt = 'Recept kép';
            img.style.width = '100%';
            imageContainer.appendChild(img);
        }

        document.getElementById('viewRecipeModal').classList.add('active');
        document.getElementById('overlay').classList.add('active');
    }

    function closeRecipeModal() {
        document.getElementById('viewRecipeModal').classList.remove('active');
        document.getElementById('overlay').classList.remove('active');
    }

    function closeAllModals() {
        closeAddRecipeModal();
        closeRecipeModal();
    }
</script>