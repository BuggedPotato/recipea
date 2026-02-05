<?php
require_once __DIR__ . '/../config/auth.php';

redirectIfAuthenticated();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>

    <h2>Rejestracja</h2>
    <form method="POST" action="./api/register">
        <input id="r-username" name="username" placeholder="Username">
        <input id="r-email" name="email" placeholder="Email">
        <input id="r-display" name="display" placeholder="Display name">
        <input id="r-password" name="password" type="password" placeholder="Password">
        <button type="submit">Zarejestruj</button>
    </form>
    <a href="./login">Logowanie</a>

</body>
</html>
