<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <!-- Térkép-->
        <td style="width: 50%; vertical-align: top; padding: 10px; border: 1px solid #ddd;">
            <h2>Adatok:</h2>
            <p>Ügyvezető: <strong>Gipsz Jakab</strong></p>
            <p>E-mail: <strong>Gipsz.Jakab@kuckos.hu</strong></p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10905.999545842029!2d19.6574799003615!3d46.89288649670877!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4743dbe3bf8485cb%3A0xc114afde97ee58a0!2sBistorant%20Kecskem%C3%A9t!5e0!3m2!1shu!2shu!4v1745749048252!5m2!1shu!2shu" 
                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </td>

        <!-- Üzenetküldés-->
        <td style="width: 50%; vertical-align: top; padding: 10px; border: 1px solid #ddd;">
            <h2>Kapcsolatfelvétel</h2>
            <form id="kapcsolatForm" method="post" action="kapcsolat_feldolgozas.tpl.php">
                <label for="uzenet">Üzenet az oldal üzemeltetőinek:</label><br>
                <textarea id="uzenet" name="uzenet" rows="5" style="width: 100%; resize: none;" required></textarea><br><br>
                <button type="submit" style="float: right; padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">Küldés</button>
            </form>
        </td>
    </tr>
</table>

<script>
    document.getElementById('kapcsolatForm').addEventListener('submit', function (e) {
        const uzenet = document.getElementById('uzenet').value.trim();

        if (!uzenet) {
            e.preventDefault();
            alert('Kérjük, írjon be egy üzenetet!');
        }
    });
</script>