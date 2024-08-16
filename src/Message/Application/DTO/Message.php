<?php

namespace App\Message\Application\DTO;

use App\Message\Domain\Message as DomainMessage;

final class Message
{
    public ?string $title;
    public ?string $text;
}