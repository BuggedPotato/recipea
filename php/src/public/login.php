<?php
require_once __DIR__ . '/../config/auth.php';
redirectIfAuthenticated();
require_once __DIR__ . '/templates/loader.php';
loadTemplate("header");
loadTemplate("navbar");
?>


    <h2>Logowanie</h2>
    <form class="flex flow-col w-50" method="POST" action="./api/login">
        <label for="username">
            Nazwa użytkownika:
        </label>
        <input id="l-username" name="username" placeholder="Username" required>
        <label for="password">
            Hasło:
        </label>
        <input id="l-password" name="password" type="password" placeholder="Password" required>
        <button class="btn primary rounded" type="submit">Zaloguj</button>
    </form>
    <a href="./register">Rejestracja</a>

</body>
</html>
