<?php

function getPermissionList($role_id){
    $stmt = $pdo->prepare('
    SELECT name FROM permissions
    INNER JOIN roles_permissions ON roles_permissions.permissions_id_permissions = permissions.id_permissions
    WHERE roles_permissions.roles_id_roles = :role_id');

    $stmt->execute(['role_id' => $role_id]);
    return $stmt->fetch(PDO:FETCH_ASSOC);
}

header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Nieautoryzowany']);
    exit;
}

echo json_encode([
    'success' => true,
    'perms' => getPermissionList($_SESSION['role_id'])['name']
]);


