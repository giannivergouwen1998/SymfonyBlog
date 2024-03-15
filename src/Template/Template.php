<?php

namespace App\Template;

use function str_contains;
use function str_replace;

final class Template
{
    public function __construct(
       public string $template
    )
    {
    }
}