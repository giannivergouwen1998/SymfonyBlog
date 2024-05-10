<?php

namespace App\Template;

use Symfony\Component\HttpFoundation\Response;
use function array_filter;
use function array_map;
use function array_unique;
use function dd;
use function file_get_contents;
use function preg_match;
use function preg_match_all;
use function str_contains;
use function str_replace;

final class TemplateEngine
{
    public static function render(string $template, array $values): Response
    {
        $template = file_get_contents(__DIR__."/../../templates/$template");

        foreach ($values as $key => $value)
        {
            $template = str_replace("{{ $key }}", $value, $template);
        }

        return new Response($template);
    }
}