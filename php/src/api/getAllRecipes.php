<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';

$stmt = $pdo->prepare("
    SELECT r.id_recipes AS id, r.title, r.description, r.ingredients, r.steps, f.name AS \"image\"
    FROM recipes AS r
    INNER JOIN files_recipes AS fr ON r.id_recipes = fr.recipes_id_recipes
    INNER JOIN files AS f ON f.id_files = fr.files_id_files;
");

$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($recipes);
