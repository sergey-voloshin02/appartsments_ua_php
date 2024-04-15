<?php

require 'vendor/autoload.php';

use Components\Database;
use Components\Router;
use Controllers\UserController;

$db = new Database();
$pdo = $db->getConnection();

$router = new Router();

// Реєстрація
$router->add('POST', '/register', function () use ($pdo) {
    $data = (array) json_decode(file_get_contents('php://input'), true);

    $registration = new UserController($pdo);
    return $registration->register($data);
});

// Авторизація
$router->add('POST', '/login', function () use ($pdo) {
    $data = (array) json_decode(file_get_contents('php://input'), true);

    $registration = new UserController($pdo);
    return $registration->login($data);
});

// Отримання даних по юзеру
$router->add('GET', '/user', function () use ($pdo) {

    // $registration = new UserController($pdo);
    // return $registration->login($data);
});

// Редагування юзера
$router->add('POST', '/user', function () use ($pdo) {
    $data = (array) json_decode(file_get_contents('php://input'), true);

    // $registration = new UserController($pdo);
    // return $registration->login($data);
});

$router->setNotFound(function () {
    http_response_code(404);
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Route not found'
    ), JSON_UNESCAPED_UNICODE);
});

$router->dispatch();
