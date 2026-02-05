<?php

require_once __DIR__ . '/../config/session.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$endpoints = [
    '/api/login' => ['method' => 'POST', 'path' => '/../api/login.php'],
    '/api/register' => ['method' => 'POST', 'path' => '/../api/register.php'],
    '/api/logout' => ['method' => 'GET', 'path' => '/../api/logout.php'],
    '/api/me' => ['method' => 'GET', 'path' => '/../api/me.php'],
    '/api/perms' => ['method' => 'POST', 'path' => '/../api/perms.php']
];


if(array_key_exists($uri, $endpoints)){
    require __DIR__ . $endpoints[$uri]['path'];
    exit;
}


if ($uri === '/' || $uri === '/index.php') {
    readfile(__DIR__ . '/index.html');
    exit;
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Not Found']);
