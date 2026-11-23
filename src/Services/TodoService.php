<?php
declare(strict_types=1);

namespace Todo\Services;

use Todo\DTO\TodoDTO;
use Todo\Repositories\TodoRepository;

class TodoService
{
    private TodoRepository $repository;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(string|null $title, string|null $description): TodoDTO|null
    {
        if (is_null($title)) {
            return null;
        }

        $description = $description ?? "";
        $model = new TodoDTO(title: $title, description: $description);
        $rawTodo = $this->repository->create($model);

        return new TodoDTO(...$rawTodo);
    }

    public function update(string $id, string|null $title, string|null $description): TodoDTO|null
    {
        if (strlen($id) === 0) {
            return null;
        }

        if (!$title) {
            return null;
        }

        $description = $description ?? "";
        $model = new TodoDTO(id: $id, title: $title, description: $description);
        $rawTodo = $this->repository->updateById($model);

        return new TodoDTO(...$rawTodo);
    }

    public function get(string $id): TodoDTO|null
    {
        if (strlen($id) === 0) {
            return null;
        }

        $rawTodo = $this->repository->getById($id);

        return new TodoDTO(...$rawTodo);
    }

    public function getList(): array
    {
        $rawTodoList = $this->repository->getList();

        return array_map(fn(array $rawTodo) => new TodoDTO(...$rawTodo), $rawTodoList);
    }
}
