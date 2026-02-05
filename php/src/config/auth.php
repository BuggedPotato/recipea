<?php

function requireAuth() : void
{
    if (!isset($_SESSION['user'])) {
        header('Location: ../login');
    }
}

function redirectIfAuthenticated(){
    if(isset($_SESSION['user'])){
        header('Location: ../');
    }
}

function requireRole(string $role) : void
{
    requireAuth();

    if ($_SESSION['user']['role_name'] !== $role) {
        http_response_code(403);
        echo json_encode(['error' => 'Forbidden']);
        exit;
    }
}
