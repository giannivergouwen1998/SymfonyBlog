<?php

namespace App\Config;

use Exception;

final class DiContainer
{
    /** @var array<> */
    private array $bindings = [];

    public function set(string $id, callable $factory): void
    {
        $this->bindings[$id] = $factory;
    }

    public function get(string $id): array
    {
        if(!isset($this->bindings[$id]))
        {
            throw new Exception("{$id} does not exist");
        }

        $factory = $this->bindings[$id];

        return $factory($this);
    }
}