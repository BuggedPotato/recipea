<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';

$data = json_decode(file_get_contents("php://input"));
$recipe_id = $data->recipe_id ?? '';

if (!$recipe_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Brak danych']);
    exit;
}

$stmt = $pdo->prepare("
    SELECT r.id_recipes AS id, r.title, r.description, r.ingredients, r.steps, f.name AS \"image\", ur.users_id_users AS owner_id
    FROM recipes AS r
    INNER JOIN files_recipes AS fr ON r.id_recipes = fr.recipes_id_recipes
    INNER JOIN files AS f ON f.id_files = fr.files_id_files
    INNER JOIN users_recipes AS ur ON r.id_recipes = ur.recipes_id_recipes
    WHERE r.id_recipes = :needle;
");

$stmt->execute([':needle' => $recipe_id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    http_response_code(400);
    echo json_encode(['error' => 'Nie znaleziono przepisu']);
    exit;
}

$recipe['ingredients'] = json_decode($recipe['ingredients']);
$recipe['steps'] = json_decode($recipe['steps']);

echo json_encode($recipe);
