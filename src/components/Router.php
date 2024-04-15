<?php

namespace Components;

class Router {
    protected $routes = [];
    protected $notFound;

    public function add($method, $uri, $handler) {
        $this->routes[$method][$uri] = $handler;
    }

    public function setNotFound($handler) {
        $this->notFound = $handler;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method][$uri])) {
            return call_user_func($this->routes[$method][$uri]);
        }
        
        if ($this->notFound) {
            return call_user_func($this->notFound);
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}
