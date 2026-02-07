<?php

require_once __DIR__ . '/../config/session.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$endpoints = [
    '/api/login' => ['method' => 'POST', 'path' => '/login.php'],
    '/api/register' => ['method' => 'POST', 'path' => '/register.php'],
    '/api/logout' => ['method' => 'GET', 'path' => '/logout.php'],
    '/api/me' => ['method' => 'GET', 'path' => '/me.php'],
    '/api/perms' => ['method' => 'POST', 'path' => '/perms.php'],

    '/api/createRecipe' => ['method' => 'POST', 'path' => '/createRecipe.php'],
    '/api/getRecipe' => ['method' => 'POST', 'path' => '/getRecipe.php'],
    '/api/getAllRecipes' => ['method' => 'POST', 'path' => '/getAllRecipes.php'],
    '/api/getUserRecipes' => ['method' => 'POST', 'path' => '/getUserRecipes.php'],
    '/api/deleteRecipe' => ['method' => 'POST', 'path' => '/deleteRecipe.php'],
];

if(array_key_exists($uri, $endpoints) && $endpoints[$uri]['method'] == $method){
    require __DIR__ . $endpoints[$uri]['path'];
    exit;
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Not Found']);
