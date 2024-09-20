<?php

namespace App\Message\Domain;

use RuntimeException;

final class MessageNotFound extends RuntimeException
{
    public static function withMessageId(MessageId $messageId): self
    {
        return new self(
            "Message not found with id: {$messageId}"
        );
    }
}