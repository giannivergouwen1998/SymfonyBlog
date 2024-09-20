<?php

namespace App\Message\Application;

use App\Message\Domain\Message;
use App\Message\Domain\MessageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class PostMessageHandler
{
    public function __construct(
        public MessageRepository $messageRepository,
    )
    {
    }

    public function __invoke(PostMessage $command)
    {
        $message = Message::post(
            $command->title,
            $command->text
        );


        $this->messageRepository->add(
            $message
        );
    }
}