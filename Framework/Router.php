<?php
declare(strict_types=1);

namespace Framework;

class Router
{
    private \Framework\Container $container;
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => [],
    ];

    public function __construct(\Framework\Container $c)
    {
        $this->container = $c;
    }

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

    public function patch(string $path, callable|array $handler): void
    {
        $this->routes['PATCH'][$path] = $handler;
    }

    public function delete(string $path, callable|array $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch(string $method, string $url): void
    {
        foreach ($this->routes[$method] ?? [] as $path => $handler) {
            $pattern = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $path) . '$#';

            if (!preg_match($pattern, $url, $matches)) {
                continue;
            }

            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            $json = file_get_contents('php://input');
            $data = (array)json_decode($json) ?? [];
            $request = new Request(
                body: $data,
                params: $params,
            );

            if (is_array($handler) && is_string($handler[0])) {
                [$class, $action] = $handler;

                $controller = $this->container->get($class);
                $controller->$action($request);

                return;
            }

            $handler($request);

            return;
        }

        http_response_code(404);
        echo json_encode(['error' => 'not found']);
    }
}
