<?php

namespace App\Message\Domain;

use Assert\Assertion;
use function assert;

final readonly class Message
{
    private function __construct(
        public string $title,
        public string $text,
    )
    {
        Assertion::notEmpty($this->title);
        Assertion::notEmpty($this->text);
    }

    public static function load(
        string $title,
        string $text,
    ): self
    {
        return new self(
            $title,
            $text
        );
    }
}