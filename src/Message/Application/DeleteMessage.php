<?php

namespace App\Message\Application;

use App\Message\Domain\MessageId;

final readonly class DeleteMessage
{
    public function __construct(
        public MessageId $messageId,
    )
    {
    }
}