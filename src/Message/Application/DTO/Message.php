<?php

namespace App\Message\Application\DTO;

use App\Message\Domain\Message as DomainMessage;
use App\Message\Domain\MessageId;

final class Message
{
    public ?MessageId $messageId;
    public ?string $title;
    public ?string $text;

    public function toDomain(): DomainMessage
    {
        return DomainMessage::load(
            $this->messageId,
            $this->title,
            $this->text
        );
    }

    public static function fromDomain(DomainMessage $message): self
    {
        $dto = new self();
        $dto->messageId = $message->messageId;
        $dto->title = $message->title;
        $dto->text = $message->text;

        return $dto;
    }

}