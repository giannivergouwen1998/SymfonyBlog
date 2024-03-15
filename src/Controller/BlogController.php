<?php

namespace App\Controller;

use App\Router\Request;
use App\Router\Response;
use App\Template\Template;
use App\Template\TemplateEngine;
use function dd;
use function file_get_contents;
use function str_contains;
use function str_replace;
use function strtr;

final class BlogController
{
    public function __invoke(Request $request): Response
    {
        return new Response(
            TemplateEngine::render( 'get.html', [
               'Title' => 'Naam',
                'Hallo' => 'Test',
            ])
        );
    }


}