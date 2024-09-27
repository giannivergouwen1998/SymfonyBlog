<?php

namespace App\Message\Infrastructure;

use App\Message\Domain\Message;
use App\Message\Domain\MessageId;
use App\Message\Domain\MessageRepository;
use Doctrine\DBAL\Connection;
use Iterator;
use function dd;
use function uniqid;

final readonly class DbalMessageRepository implements MessageRepository
{
    private const string TABLE = 'posts';

    public function __construct(
        private Connection $connection,
    )
    {
    }

    public function all(): Iterator
    {
        $qb = $this->connection->createQueryBuilder();

        $result = $qb
            ->select('*')
            ->from(self::TABLE)
            ->executeQuery()
        ;

        foreach ($result->iterateAssociative() as $row)
        {
            yield self::fromDatabase($row);
        }
    }

    public function add(Message $message): void
    {
        $this->connection->insert(
            self::TABLE,
            [
                'id' => $message->messageId->messageId,
                ...$this->toDatabase($message)
            ]
        );
    }

    public function find(MessageId $messageId): Message
    {
        $qb = $this->connection->createQueryBuilder();

        $result = $qb->select('*')
            ->from(self::TABLE)
            ->where(
            "id = :messageId")
            ->setParameter('messageId', $messageId->messageId)
            ->executeQuery()
        ;

        return self::fromDatabase($result->fetchAssociative());
    }

    /** @param array<string, mixed> $result */
    private static function fromDatabase(array $result): Message
    {
        return Message::load(
            MessageId::fromString($result['id']),
            $result['title'],
            $result['text'],
        );
    }

    public function save(Message $message): void
    {
        $this->connection->update(
            self::TABLE,
            $this->toDatabase($message),
            [
                'id' => $message->messageId->messageId
            ]
        );
    }

    /** @return array<string, mixed> */
    private function toDatabase(Message $message): array
    {
        return [
            'title' => $message->title,
            'text' => $message->text,
        ];
    }

    public function delete(MessageId $messageId): void
    {
        $this->connection->delete(
            self::TABLE,
            [
                'id' => $messageId->messageId
            ]
        );
    }
}