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

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, callable $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, callable $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch(string $method, string $url): void
    {
        $cb = $this->routes[$method][$url] ?? null;

        if ($cb === null) {
            http_response_code(404);
            echo json_encode(['error' => 'not found']);
            return;
        }

        $cb();
    }
}
