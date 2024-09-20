<?php

namespace App\Message\Domain;

use Iterator;

interface MessageRepository
{
    /** @return Iterator<Message> */
    public function all(): Iterator;
    public function add(Message $message): void;
    public function find(MessageId $messageId): Message;
}