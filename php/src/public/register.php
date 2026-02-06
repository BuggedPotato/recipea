<?php
require_once __DIR__ . '/../config/auth.php';
redirectIfAuthenticated();
require_once __DIR__ . '/templates/loader.php';
loadTemplate("header");
loadTemplate("navbar");
?>
    <h2>Rejestracja</h2>
    <form class="flex flow-col w-50" method="POST" action="./api/register">
        <input id="r-username" name="username" placeholder="Username">
        <input id="r-email" name="email" placeholder="Email">
        <input id="r-display" name="display" placeholder="Display name">
        <input id="r-password" name="password" type="password" placeholder="Password">
        <button class="btn primary rounded" type="submit">Zarejestruj</button>
    </form>
    <a href="./login">Logowanie</a>

</body>
</html>
