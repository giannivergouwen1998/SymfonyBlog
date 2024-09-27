<?php

namespace App\Message\Application;

use App\Message\Domain\Message;
use App\Message\Domain\MessageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteMessageHandler
{
    public function __construct(
        public MessageRepository $messageRepository,
    )
    {
    }

    public function __invoke(DeleteMessage $command): void
    {
        $message = $this->messageRepository->find($command->messageId);

        $this->messageRepository->delete(
            $message->delete()->messageId
        );
    }
}