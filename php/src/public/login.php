<?php
require_once __DIR__ . '/../config/auth.php';
redirectIfAuthenticated();
require_once __DIR__ . '/templates/loader.php';
loadTemplate("header");
?>
<div class="flex flow-row h-100 w-100">
    <img class="w-50 h-100" src="/res/login_background.png" style="object-fit: cover;"/>

    <div class="flex flow-col full-center w-50 h-100">
        <div class="flex flow-row" style="align-items: center; padding: 1rem;">
            <img src="/res/logo.png" width="128" height="128"  />
            <p class="app-name" style="font-size: 4rem;">Recipea</p>
        </div>
        <h2>Logowanie</h2>
        <form class="flex flow-col" style="width: 35%" method="POST" action="./api/login">
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
        <a href="./register" style="margin: 1rem;">Rejestracja</a>
    </div>
</div>
</body>
</html>
