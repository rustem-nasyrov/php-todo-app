<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
$container = require __DIR__ . '/Bootstrap.php';

use Framework\Router;
use Todo\Controllers\TodoController;

header('Content-Type: application/json');

$router = new Router($container);
$router->get('/todos', [TodoController::class, 'all']);
$router->get('/todos/{id}', [TodoController::class, 'get']);
$router->post('/todos', [TodoController::class, 'create']);
$router->patch('/todos/{id}', [TodoController::class, 'patch']);
$router->delete('/todos/{id}', [TodoController::class, 'delete']);

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
