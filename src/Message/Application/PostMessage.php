<?php

namespace App\Message\Application;

use App\Message\Domain\MessageId;

final readonly class PostMessage
{
    public function __construct(
        public ?string $title,
        public ?string $text,
    )
    {
    }
}