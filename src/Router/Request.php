<?php

namespace App\Router;

final class Request
{
    private function __construct(private readonly string $path, private readonly Method $method, private array $parameters, private array $headers)
    {
    }

    public static function init(): self
    {
        return new self(
            $_SERVER['REQUEST_URI'],
            Method::from($_SERVER['REQUEST_METHOD']),
            [],
            [],
        );
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): Method
    {
        return $this->method;
    }
}