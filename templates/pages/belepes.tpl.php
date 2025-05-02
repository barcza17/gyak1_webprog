    <form action = "logicals/belep.php" method = "POST">
      <fieldset>
        <legend>Bejelentkezés</legend>
        <br>
        <input type="text" name="felhasznalonev" placeholder="Felhasználónév" required><br><br>
        <input type="password" name="jelszo" placeholder="Jelszó" required><br><br>
        <input type="submit" name="belepes" value="Belépés">
        <br>&nbsp;
      </fieldset>
    </form>
    <h3>Regisztrálja magát, ha még nem felhasználó!</h2>
    <form action = "regisztral" method = "POST">
      <fieldset>
        <legend>Regisztráció</legend>
        <br>
        <input type="text" name="vezeteknev" placeholder="Vezetéknév" required><br><br>
        <input type="text" name="utonev" placeholder="Utónév" required><br><br>
        <input type="text" name="felhasznalonev" placeholder="Felhasználónév" required><br><br>
        <input type="password" name="jelszo" placeholder="Jelszó" required><br><br>
        <input type="submit" name="regisztracio" value="Regisztráció">
        <br>&nbsp;
      </fieldset>
    </form>
