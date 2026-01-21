<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/session.php';

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Nieautoryzowany']);
    exit;
}

echo json_encode([
    'authenticated' => true,
    'user' => $_SESSION['user']
]);

