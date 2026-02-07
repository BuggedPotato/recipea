<?php

require_once __DIR__ . '/../../config/session.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $uri);
$method = $_SERVER['REQUEST_METHOD'];

$endpoints = [
    // misses first '/' because trim in line 5
    'recipes/new' => ['method' => 'GET', 'path' => '/new.php'],
    'recipes/list' => ['method' => 'GET', 'path' => '/list.php'],
    // 'recipes/details' => ['method' => 'GET', 'path' => '/details.php'],
    'recipes/myRecipes' => ['method' => 'GET', 'path' => '/myRecipes.php'],
];

if(array_key_exists($uri, $endpoints) && $endpoints[$uri]['method'] == $method){
    require __DIR__ . $endpoints[$uri]['path'];
    exit;
}

if(str_starts_with($uri, 'recipes/details') && isset($segments[2]) && ctype_digit($segments[2])){
    $recipe_id = (int)$segments[2];
    $uri = join('/', array_slice($segments, 0, count($segments)-1));
    require __DIR__ . '/details.php';
    exit;
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Not Found']);
