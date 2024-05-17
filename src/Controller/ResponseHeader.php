<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

final readonly class ResponseHeader
{
    public function __construct(
        private Response $response,
    )
    {
    }

    public function setHeader(string $key, string $value): void
    {
        $this->response->headers->set($key, $value);
    }
}