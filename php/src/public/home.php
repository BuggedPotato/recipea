<?php
    require_once __DIR__ . '/../config/auth.php';
    requireAuth();

    require_once __DIR__ . '/templates/loader.php';
    loadTemplate("header");
    loadTemplate("navbar");
?>

<h2>Home</h2>
<form method="GET" action="./api/logout">
    <button class="btn primary rounded" type="submit">Wyloguj</button>
</form>

</body>
</html>

