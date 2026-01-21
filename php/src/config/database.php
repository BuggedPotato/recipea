<?php

$host = 'postgres';
$db   = 'app_db';
$user = 'app_user';
$pass = 'secret';

try {
    $pdo = new PDO(
        "pgsql:host=$host;dbname=$db",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Błąd połączenia z bazą']);
    exit;
}

