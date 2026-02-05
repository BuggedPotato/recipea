<?php
require_once __DIR__ . '/../config/auth.php';

requireAuth();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
<!--     <script src="auth.js"></script> -->
</head>
<body>

<h2>Home</h2>
<form method="GET" action="./api/logout">
    <button type="submit">Wyloguj</button>
</form>

</script>
</body>
</html>

