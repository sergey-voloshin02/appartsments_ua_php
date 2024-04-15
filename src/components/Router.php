<?php

namespace Components;

class Router
{
    // Массив для хранения ассоциации маршрутов и их обработчиков
    protected $routes = [];

    // Обработчик для несуществующих маршрутов
    protected $notFound;

    // Добавляет маршрут и его обработчик в массив маршрутов
    public function add($uri, $handler)
    {
        $this->routes[$uri] = $handler;
    }

    // Устанавливает функцию, которая будет вызвана, если маршрут не найден
    public function setNotFound($handler)
    {
        $this->notFound = $handler;
    }

    // Осуществляет диспетчеризацию запросов, сопоставляя URI запроса с зарегистрированными маршрутами
    public function dispatch()
    {
        // Получаем URI текущего запроса
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Проверяем, существует ли обработчик для данного URI
        if (array_key_exists($uri, $this->routes)) {
            // Если обработчик найден, вызываем его
            return call_user_func($this->routes[$uri]);
        }

        // Если маршрут не найден, проверяем, установлен ли обработчик для несуществующих маршрутов
        if ($this->notFound) {
            // Вызываем обработчик несуществующего маршрута
            return call_user_func($this->notFound);
        }

        // Если обработчик не найден, отправляем HTTP-ответ 404
        http_response_code(404);
        echo '404 Not Found';
    }
}
