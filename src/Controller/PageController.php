<?php

namespace App\Controller;

use App\Template\TemplateEngine;
use Symfony\Component\HttpFoundation\Response;

final readonly class PageController
{
    public function __construct(
    )
    {
    }

    public static function viewIndex(): Response
    {
        $response = TemplateEngine::render('get.html', [
            'Title' => 'Hoi'
        ]);

        return $response;
    }
}