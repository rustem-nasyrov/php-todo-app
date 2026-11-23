<?php
declare(strict_types=1);

namespace Todo\Controllers;

use Todo\Request;
use Todo\Services\TodoService;

class TodoController
{
    private TodoService $service;

    public function __construct(TodoService $service)
    {
        $this->service = $service;
    }

    public function all(): void
    {
        $list = $this->service->getList();

        http_response_code(200);
        echo json_encode($list);
    }

    public function get(Request $request): void
    {
        $todo = $this->service->get($request->params['id']);

        if (is_null($todo)) {
            http_response_code(404);
            return;
        }

        http_response_code(200);
        echo json_encode($todo);
    }

    public function create(Request $request): void
    {
        $title = $request->body['title'] ?? null;
        $description = $request->body['description'] ?? null;
        $result = $this->service->create($title, $description);

        if (is_null($result)) {
            http_response_code(400);

            return;
        }

        http_response_code(201);
        echo json_encode([
            "id" => $result,
        ]);
    }

    public function patch(Request $request): void
    {
        $id = $request->params['id'] ?? null;

        if (is_null($id)) {
            http_response_code(400);

            return;
        }

        echo json_encode(['action' => 'update']);
    }

    public function delete(Request $request): void
    {
        echo json_encode(['action' => 'delete']);
    }
}
