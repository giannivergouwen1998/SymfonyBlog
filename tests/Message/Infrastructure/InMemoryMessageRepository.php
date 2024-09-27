<?php

namespace Message\Infrastructure;

use App\Message\Domain\Message;
use App\Message\Domain\MessageId;
use App\Message\Domain\MessageNotFound;
use App\Message\Domain\MessageRepository;
use Iterator;
use function array_key_exists;

final class InMemoryMessageRepository implements MessageRepository
{
    /** @var array<string, Message> $messages*/
    private array $messages = [];

    public function all(): Iterator
    {
        yield from $this->messages;
    }

    public function add(Message $message): void
    {
        $this->messages[$message->messageId->messageId] = $message;
    }

    public function find(MessageId $messageId): Message
    {
        return $this->messages[$messageId->messageId] ?? throw MessageNotFound::withMessageId($messageId);
    }

    public function save(Message $message): void
    {
        if (!$this->exists($message->messageId))
        {
            throw MessageNotFound::withMessageId($message->messageId);
        }

        $this->messages[$message->messageId->messageId] = $message;
    }

    private function exists(MessageId $messageId): bool
    {
        return array_key_exists($messageId->messageId, $this->messages);
    }

    public function delete(MessageId $messageId): void
    {
        unset($this->messages[$messageId->messageId]);
    }
}