<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['siker'])) {
    echo "<script>alert('Sikeres regisztráció! Most már bejelentkezhetsz.');</script>";
}
if (isset($_GET['hiba'])) {
    echo "<script>alert('Hiba történt a regisztráció során! (Kód: " . htmlspecialchars($_GET['hiba']) . ")');</script>";
}
?>

<div style="max-width: 600px; margin: auto; padding: 20px;">
    <!-- Bejelentkezés -->
    <form action="logicals/belep.php" method="POST" style="margin-bottom: 30px;">
        <fieldset style="border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
            <legend><strong>Bejelentkezés</strong></legend>
            <input type="text" name="felhasznalonev" placeholder="Felhasználónév" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
            <input type="password" name="jelszo" placeholder="Jelszó" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
            <input type="submit" name="belepes" value="Belépés" style="width: 100%; padding: 10px;">
        </fieldset>
    </form>

    <h3 style="text-align: center;">Regisztrálja magát, ha még nem felhasználó!</h3>

    <!-- Regisztráció -->
    <form action="logicals/regisztral.php" method="POST">
        <fieldset style="border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
            <legend><strong>Regisztráció</strong></legend>
            <input type="text" name="vezeteknev" placeholder="Vezetéknév" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
            <input type="text" name="utonev" placeholder="Utónév" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
            <input type="text" name="felhasznalo" placeholder="Felhasználónév" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
            <input type="password" name="jelszo" placeholder="Jelszó" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
            <input type="submit" name="regisztracio" value="Regisztráció" style="width: 100%; padding: 10px;">
        </fieldset>
    </form>
</div>
