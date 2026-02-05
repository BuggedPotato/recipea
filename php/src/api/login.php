<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/validator.php';

$data = json_decode(file_get_contents('php://input'), true);

$username = sanitize($data['username'] ?? '');
$password = $data['password'] ?? '';

if (!$username || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Brak danych']);
    exit;
}

$stmt = $pdo->prepare("
    SELECT id_users, password, display_name, id_roles
    FROM users
    WHERE username = :username
");

$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Nieprawidłowe dane logowania']);
    exit;
}

session_regenerate_id(true);

$_SESSION['user'] = [
    'id' => $user['id_users'],
    'display_name' => $user['display_name'],
    'role_id' => $user['id_roles']
];

echo json_encode([
    'success' => true,
    'user' => $_SESSION['user']
]);
