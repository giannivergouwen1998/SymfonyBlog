<?php

namespace App\Message\Domain;

use Assert\Assertion;
use Stringable;
use Symfony\Component\Uid\Uuid;
use function uniqid;

final readonly class MessageId
{
    public function __construct(
        public string $messageId
    )
    {
        Assertion::uuid($this->messageId);
    }

    public static function generate(): self
    {
        return new self(
            Uuid::v4()->toString()
        );
    }

    public function __toString(): string
    {
        return $this->messageId;
    }

    public static function fromString(string $messageId): self
    {
        return new self($messageId);
    }
}