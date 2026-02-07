<?php

require_once __DIR__ . '/../../config/session.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$endpoints = [
    '/user/profile' => ['method' => 'GET', 'path' => '/profile.php'],
];

if(array_key_exists($uri, $endpoints) && $endpoints[$uri]['method'] == $method){
    require __DIR__ . $endpoints[$uri]['path'];
    exit;
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Not Found']);
