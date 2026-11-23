<?php
declare(strict_types=1);

namespace Todo;

readonly class Request
{
    public function __construct(public array $body, public array $params)
    {

    }
}