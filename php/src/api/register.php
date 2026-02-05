<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/validator.php';


// $data = json_decode(file_get_contents('php://input'), true);

// $username = sanitize($data['username'] ?? '');
// $email = sanitize($data['email'] ?? '');
// $displayName = sanitize($data['display_name'] ?? '');
// $password = $data['password'] ?? '';

$username = $_POST['username'];
$email = $_POST['email'];
$displayName = $_POST['display'];
$password = $_POST['password'];

if (!$username || !$email || !$displayName || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Brak wymaganych danych']);
    exit;
}

if (!validateEmail($email)) {
    http_response_code(422);
    echo json_encode(['error' => 'Niepoprawny email']);
    exit;
}

if (!validatePassword($password)) {
    http_response_code(422);
    echo json_encode(['error' => 'Hasło musi mieć min. 8 znaków']);
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO users (username, email, display_name, password)
    VALUES (:username, :email, :display_name, :password)
");

try {
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':display_name' => $displayName,
        ':password' => $passwordHash
    ]);

    // echo json_encode(['success' => true]);
    header("Location: ../");
} catch (PDOException $e) {
    http_response_code(409);
    echo json_encode(['error' => 'Użytkownik już istnieje']);
}

