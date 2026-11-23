<?php
declare(strict_types=1);

namespace Framework;

class Container
{
    private array $map = [];
    private array $cache = [];

    public function get(string $key): mixed
    {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        if (!isset($this->map[$key])) {
            throw new \RuntimeException("Could not call the $key");
        }

        $this->cache[$key] = $this->map[$key]($this);

        return $this->cache[$key];
    }

    public function bind(string $key, callable $factory): void
    {
        $this->map[$key] = $factory;
    }
}
