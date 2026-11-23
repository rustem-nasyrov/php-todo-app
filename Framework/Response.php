<?php

namespace Framework;

class Response
{
    public function __construct(public readonly array $data, public readonly array $error)
    {
    }
}