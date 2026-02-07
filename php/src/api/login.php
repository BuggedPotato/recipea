<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/validator.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!$username || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Brak danych']);
    exit;
}

$stmt = $pdo->prepare("
    SELECT id_users, password, username, display_name, users.id_roles, name
    FROM users
    INNER JOIN roles ON users.id_roles = roles.id_roles
    WHERE users.username = :username
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
    'username' => $user['username'],
    'role_id' => $user['id_roles'],
    'role_name' => $user['name']
];

// echo json_encode([
//     'success' => true,
//     'user' => $_SESSION['user']
// ]);

header("Location: ../");
