<?php

namespace App\Router;

use Symfony\Component\Routing\Exception\InvalidArgumentException;

final readonly class RoutingOptions
{
    private function __construct(
        public string $className,
        public string $method,
    )
    {
        if (!class_exists($className))
        {
            throw new InvalidArgumentException();
        }
    }

    public static function create(string $className, string $method): self
    {
        return new self(
            $className,
            $method
        );
    }

    public function __toString(): string
    {
        return "{$this->className}::{$this->method}";
    }
}