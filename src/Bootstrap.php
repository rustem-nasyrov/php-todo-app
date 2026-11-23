<?php
declare(strict_types=1);

namespace Todo;

use Todo\Database;
use Todo\Utils\Container;
use Todo\Controllers\TodoController;
use Todo\Services\TodoService;
use Todo\Repositories\TodoRepository;

$container = new Container();

$container->bind(\PDO::class, fn() => Database::connect());
$container->bind(TodoController::class, fn($c) => new TodoController($c->get(TodoService::class)));
$container->bind(TodoService::class, fn($c) => new TodoService($c->get(TodoRepository::class)));
$container->bind(TodoRepository::class, fn($c) => new TodoRepository($c->get(\PDO::class)));

return $container;
