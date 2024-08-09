<?php

namespace User\UI\Controller;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class IndexTest extends WebTestCase
{
    #[Test]
    public function it_can_view_page(): void {

        $client = $this->createClient();

        $client->request('POST', '/');

        self::assertPageTitleSame('Symfony Blog');
    }
}