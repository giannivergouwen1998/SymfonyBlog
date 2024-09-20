<?php

namespace App\Message\Domain;

use Assert\Assertion;
use function assert;

final readonly class Message
{
    private function __construct(
        public MessageId $messageId,
        public string $title,
        public string $text,
    )
    {
        Assertion::notEmpty($this->title);
        Assertion::notEmpty($this->text);
    }

    public static function load(
        MessageId $messageId,
        string $title,
        string $text,
    ): self
    {
        return new self(
            $messageId,
            $title,
            $text,
        );
    }

    public static function post(
        string $title,
        string $text,
    ): self
    {
        return new self(
            MessageId::generate(),
            $title,
            $text
        );
    }
}