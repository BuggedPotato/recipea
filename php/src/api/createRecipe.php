<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/database.php';

requireAuth();

if (!isset($_FILES['image'], $_POST['recipe'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Brak danych']);
    exit;
}

$recipe = json_decode($_POST['recipe'], true);

if (!$recipe) {
    http_response_code(400);
    echo json_encode(['error' => 'Niepoprawny JSON']);
    exit;
}


$image = $_FILES['image'];

if ($image['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'Błąd uploadu']);
    exit;
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $image['tmp_name']);

if (!in_array($mime, $allowedTypes)) {
    http_response_code(415);
    echo json_encode(['error' => 'Nieobsługiwany typ pliku']);
    exit;
}

$extension = match ($mime) {
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
};

$filename = uniqid('recipe_', true) . '.' . $extension;
$uploadDir = __DIR__ . '/../uploads/recipes/';
$destination = $uploadDir . $filename;


if (!move_uploaded_file($image['tmp_name'], $destination)) {
    http_response_code(500);
    echo json_encode(['error' => 'Nie udało się zapisać pliku']);
    exit;
}
chmod($destination, 0777);


$pdo->beginTransaction();

try {
    // image
    $stmt = $pdo->prepare("
    INSERT INTO files (name, type)
    VALUES (:filename, :type)
    RETURNING id_files
    ");

    $stmt->execute([
        ':filename' => $filename,
        ':type' => 'image' // hardcoded
    ]);

    $fileId = $stmt->fetchColumn();

    // recipe
    $stmt = $pdo->prepare("
    INSERT INTO recipes (title, description, ingredients, steps)
    VALUES (:title, :description, :ingredients, :steps)
    RETURNING id_recipes
    ");

    $stmt->execute([
        ':title' => $recipe['title'],
        ':description' => $recipe['description'],
        ':ingredients' => json_encode($recipe['ingredients']),
        ':steps' => json_encode($recipe['steps'])
    ]);

    $recipeId = $stmt->fetchColumn();

    $stmt = $pdo->prepare("
    INSERT INTO files_recipes (files_id_files, recipes_id_recipes)
    VALUES (:recipe_id, :file_id)
    ");

    $stmt->execute([
        ':recipe_id' => $recipeId,
        ':file_id' => $fileId
    ]);


    // user - recipe relation
    $userId = $_SESSION['user']['id'];
    $stmt = $pdo->prepare("
    INSERT INTO users_recipes (users_id_users, recipes_id_recipes)
    VALUES (:user_id, :recipe_id)
    ");

    $stmt->execute([
        ':user_id' => $userId,
        ':recipe_id' => $recipeId
    ]);

    $pdo->commit();

} catch (Throwable $e) {
    $pdo->rollBack();
    unlink($destination);

    http_response_code(500);
    echo json_encode(['error' => 'Błąd zapisu danych', 'message' => $e->getMessage()]);
    exit;
}

echo json_encode([
    'success' => true,
    'recipe_id' => $recipeId,
    'image' => $filename
]);
