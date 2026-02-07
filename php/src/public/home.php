<?php
    require_once __DIR__ . '/../config/auth.php';
    requireAuth();

    require_once __DIR__ . '/templates/loader.php';
    loadTemplate("header");
    loadTemplate("navbar");
?>

<h2>Strona główna</h2>

</body>
</html>

