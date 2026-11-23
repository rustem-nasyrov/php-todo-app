<?php
declare(strict_types=1);

namespace Todo\DTO;

readonly class TodoDTO
{
    public function __construct(
        public ?string $id = null,
        public string  $title,
        public string  $description,
        public bool    $is_complete = false,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        public ?string $deleted_at = null,
        public ?string $completed_at = null,
    )
    {
    }
}
