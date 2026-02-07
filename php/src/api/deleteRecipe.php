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

// get image filename
$stmt = $pdo->prepare("
    SELECT f.name AS \"image\"
    FROM recipes AS r
    INNER JOIN files_recipes AS fr ON r.id_recipes = fr.recipes_id_recipes
    INNER JOIN files AS f ON f.id_files = fr.files_id_files
    WHERE r.id_recipes = :needle;
");

$stmt->execute([':needle' => $recipe_id]);
$image = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$image) {
    http_response_code(400);
    echo json_encode(['error' => 'Nie znaleziono obrazka dla przepisu']);
    exit;
}
$image = $image['image'];

// remove recipe
$stmt = $pdo->prepare("
    DELETE FROM recipes
    WHERE recipes.id_recipes = :needle;
");

$stmt->execute([':needle' => $recipe_id]);
$count = $stmt->fetch(PDO::FETCH_DEFAULT);

if ($count == 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Nie znaleziono przepisu']);
    exit;
}

// delete image
$path = realpath(__DIR__ . '/../uploads/recipes/' . $image);
if(!is_writeable($path)){
    http_response_code(500);
    echo json_encode(['error' => 'Nie udało się usunąć pliku']);
    exit;
}
unlink($path);

echo json_encode(["success" => true]);
