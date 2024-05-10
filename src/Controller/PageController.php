<?php

namespace App\Controller;

use App\Template\TemplateEngine;
use Symfony\Component\HttpFoundation\Response;

final readonly class PageController
{
    public function __construct(
        private ResponseHeader $header,
    )
    {
    }

    public function viewIndex(): Response
    {
        $response = TemplateEngine::render('get.html', [
            'Title' => 'Hoi'
        ]);

        $this->header->setHeader('Content-Type', 'text/html; charset=utf-8');

        return $response;
    }
}