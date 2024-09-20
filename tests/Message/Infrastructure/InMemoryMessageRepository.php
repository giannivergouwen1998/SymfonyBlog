<?php

namespace Message\Infrastructure;

use App\Message\Domain\Message;
use App\Message\Domain\MessageId;
use App\Message\Domain\MessageNotFound;
use App\Message\Domain\MessageRepository;
use Iterator;

final readonly class InMemoryMessageRepository implements MessageRepository
{
    private array $messages;

    public function all(): Iterator
    {
        yield $this->messages;
    }

    public function add(Message $message): void
    {
        $this->messages[$message->messageId->messageId] = $message;
    }

    public function find(MessageId $messageId): Message
    {
        return clone $this->messages[$messageId->messageId] ?? throw MessageNotFound::withMessageId($messageId);
    }
}