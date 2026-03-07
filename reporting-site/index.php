<?php
session_start();

$path = $_GET['path'] ?? 'login';

$protected_routes = ['dashboard', 'table', 'charts'];

if (in_array($path, $protected_routes) && !isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

switch ($path) {
    case 'login':
        include 'views/login.php';
        break;
    case 'dashboard':
        include __DIR__ . '/views/dashboard.html';
        break;
    case 'api/static':
    case 'api/performance':
    case 'api/activity':
        $_GET['path'] = str_replace('api/', '', $path);
        require 'controllers/api_controller.php';
        break;
    case 'logout':
        session_destroy();
        header("Location: /login");
        exit();
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
}