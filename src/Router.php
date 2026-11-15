<?php
declare(strict_types=1);

namespace Todo;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];

    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, callable|array $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, callable|array $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch(string $method, string $url): void
    {
        $handler = $this->routes[$method][$url] ?? null;

        if ($handler === null) {
            http_response_code(404);
            echo json_encode(['error' => 'not found']);

            return;
        }

        if (is_array($handler) && is_string($handler[0])) {
            [$class, $action] = $handler;
            $controller = new $class();
            $controller->$action();

            return;
        }

        $handler();
    }
}
