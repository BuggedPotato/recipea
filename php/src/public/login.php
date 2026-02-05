<?php
require_once __DIR__ . '/../config/auth.php';

redirectIfAuthenticated();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
<!--    <script src="./auth.js"></script>
    <script>
        async function loginRedirect(){
            const res = await login();
            if(res.ok){
                window.location.replace("../../");
            }
        }
    </script>-->
</head>
<body>

    <h2>Logowanie</h2>
    <form method="POST" action="./api/login">
        <input id="l-username" name="username" placeholder="Username">
        <input id="l-password" name="password" type="password" placeholder="Password">
        <button type="submit">Zaloguj</button>
    </form>
    <a href="./register">Rejestracja</a>

</body>
</html>
