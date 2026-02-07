<?php

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if (str_starts_with($uri, '/api')) {
    require __DIR__ . '/../api/router.php';
    exit;
}
else if (str_starts_with($uri, '/user')) {
    require __DIR__ . '/user/router.php';
    exit;
}
else if (str_starts_with($uri, '/recipes')) {
    require __DIR__ . '/recipes/router.php';
    exit;
}
else if (str_starts_with($uri, '/res')) {
    require __DIR__ . '/../res/server.php';
    getResource($uri);
    exit;
}
require __DIR__ . '/router.php';
