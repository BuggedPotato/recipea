<?php

try {
    $db = new PDO(
        "pgsql:host=postgres;dbname=app_db",
        "app_user",
        "secret"
    );

    echo "Połączenie z PostgreSQL działa!";
} catch (PDOException $e) {
    echo "Błąd: " . $e->getMessage();
}

