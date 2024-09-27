<?php

namespace Message\Application;

use App\Message\Application\PostMessage;
use App\Message\Application\PostMessageHandler;
use App\Message\Domain\Message;
use App\Message\Domain\MessageId;
use Message\Infrastructure\InMemoryMessageRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PostMessageHandlerTest extends TestCase
{
    public const string MESSAGE_ID = '7c929d49-5238-426d-9547-c5b92a46b33b';

    private PostMessageHandler $handler;
    private InMemoryMessageRepository $messageRepository;

    protected function setUp(): void
    {
        $this->messageRepository = new InMemoryMessageRepository();

        $this->handler = new PostMessageHandler(
            $this->messageRepository
        );
    }

    #[Test]
    public function it_can_save_messages(): void {

        $messageId = MessageId::fromString(self::MESSAGE_ID);

        ($this->handler)(
          new PostMessage(
            'titel',
            'text'
          )
        );

        $message = $this->messageRepository->find($messageId);

        self::assertSame(
            Message::post(
                'titel',
                'text',
            ),
            $message
        );
    }
}