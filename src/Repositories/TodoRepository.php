<?php
declare(strict_types=1);

namespace Todo\Repositories;

use PDO;
use Todo\DTO\TodoDTO;

class TodoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(TodoDTO $model): mixed
    {
        $query = $this->pdo->prepare("INSERT INTO todos(title, description) VALUES (?, ?) RETURNING id;");

        $query->execute([$model->title, $model->description]);

        return $query->fetch();
    }

    public function getList(): array
    {
        $query = $this->pdo->prepare("SELECT * FROM todos;");

        $query->execute();

        return $query->fetchAll();
    }

    public function getById(string $id): ?TodoDTO
    {
        $query = $this->pdo->prepare("SELECT * FROM todos WHERE id = ?;");

        $query->execute([$id]);

        return $query->fetch();
    }

    public function updateById(TodoDTO $model): ?TodoDTO
    {
        $query = $this->pdo->prepare("UPDATE todos SET title = ?, description = ? WHERE id = ? RETURNING *;");

        $query->execute([$model->title, $model->description, $model->id]);

        return $query->fetch();
    }

    public function deleteById(string $id): null
    {
        return null;
    }
}