<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Проверка метода OPTIONS для CORS preflight запросов
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require 'vendor/autoload.php';

use Components\Database;
use Components\Router;
use Controllers\UserController;
use Controllers\PostController;

$db = new Database();
$pdo = $db->getConnection();

$router = new Router();

$userController = new UserController($pdo);
$postController = new PostController($pdo);

function returnJsonResponse($data)
{
    header('Content-Type: application/json');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// Точка входу, головна сторінка
$router->add('GET', '/main', function () use ($postController) {
    $data = (array) json_decode(file_get_contents('php://input'), true);
    returnJsonResponse($postController->main($_GET));
});

// Реєстрація
$router->add('POST', '/register', function () use ($userController) {
    $data = (array) json_decode(file_get_contents('php://input'), true);
    returnJsonResponse($userController->register($data));
});

// Авторизація
$router->add('POST', '/login', function () use ($userController) {
    $data = (array) json_decode(file_get_contents('php://input'), true);
    returnJsonResponse($userController->login($data));
});

// Отримання даних по юзеру
$router->add('GET', '/user', function () use ($userController) {
    returnJsonResponse($userController->getUser($_GET));
});

// Отримання даних по юзеру
$router->add('POST', '/logout', function () use ($userController) {
    $data = (array) json_decode(file_get_contents('php://input'), true);
    returnJsonResponse($userController->logout($data));
});

// Редагування юзера
$router->add('POST', '/user', function () use ($userController) {
    $data = (array) json_decode(file_get_contents('php://input'), true);
    return $userController->editUser($data);
});

// створення оголошення 
$router->add('POST', '/post', function () use ($postController) {
    $data = (array) json_decode(file_get_contents('php://input'), true);
    return $postController->addPost($data, $_FILES);
});

// Отримання оголошень що очікують перевірку
$router->add('GET', '/admin/posts', function () use ($postController) {
    $data = (array) json_decode(file_get_contents('php://input'), true);
    return $postController->getUncheckedPosts($data);
});

$router->setNotFound(function () {
    http_response_code(404);
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Route not found'
    ), JSON_UNESCAPED_UNICODE);
});

$router->dispatch();
