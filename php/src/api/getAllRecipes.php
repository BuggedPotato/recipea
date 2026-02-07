<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';

$stmt = $pdo->prepare("
    SELECT * FROM get_all_recipes;
");

$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($recipes);
