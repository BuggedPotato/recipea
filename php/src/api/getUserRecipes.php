<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';
requireAuth();

$stmt = $pdo->prepare("
    SELECT r.id_recipes AS id, r.title, r.description, r.ingredients, r.steps, f.name AS \"image\"
    FROM recipes AS r
    INNER JOIN files_recipes AS fr ON r.id_recipes = fr.recipes_id_recipes
    INNER JOIN files AS f ON f.id_files = fr.files_id_files
    INNER JOIN users_recipes AS ur ON r.id_recipes = ur.recipes_id_recipes
    INNER JOIN users AS u ON u.id_users = ur.users_id_users
    WHERE u.id_users = :needle;
");
$userId = $_SESSION['user']['id'];
$stmt->execute([':needle' => $userId]);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($recipes);
