<?php

namespace App\Controller;

use App\Template\TemplateEngine;
use Symfony\Component\HttpFoundation\Response;

final readonly class PageController
{
    public static function viewIndex(): Response
    {
        return TemplateEngine::render('get.html', [
            'Title' => 'Hoi'
        ]);
    }
}