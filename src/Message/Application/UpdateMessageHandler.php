<?php

namespace App\Message\Application;

use App\Message\Domain\Message;
use App\Message\Domain\MessageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateMessageHandler
{
    public function __construct(
        public MessageRepository $messageRepository,
    )
    {
    }

    public function __invoke(UpdateMessage $command): void
    {
        $message = $this->messageRepository->find($command->messageId);

        $this->messageRepository->save(
            $message->update(
                $command->title,
                $command->text,
            )
        );
    }
}