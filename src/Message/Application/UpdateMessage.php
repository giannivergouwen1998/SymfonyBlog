<?php

namespace App\Message\Application;

use App\Message\Domain\MessageId;

final readonly class UpdateMessage
{
    public function __construct(
        public MessageId $messageId,
        public ?string $title,
        public ?string $text,
    )
    {
    }
}