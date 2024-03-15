<?php

namespace App\Router;

use App\Template\Template;

final readonly class Response
{
    public function __construct(private Template $content)
    {
    }

    public function content(): string
    {
        return $this->content->template;
    }


}