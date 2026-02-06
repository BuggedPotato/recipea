<?php
require_once __DIR__ . '/../../config/auth.php';
requireAuth();
require_once __DIR__ . '/../templates/loader.php';
loadTemplate("header");
loadTemplate("navbar");
?>

<h2>Profil użytkownika
    <?php
        echo  $_SESSION['user']['username'];
    ?>
</h2>
<form class="flex flow-col w-50" method="GET" action="/api/logout">
    <button class="btn primary rounded w-25" type="submit">Wyloguj</button>
</form>

</script>
</body>
</html>
