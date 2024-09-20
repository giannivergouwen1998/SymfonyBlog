<?php

namespace User\UI\Controller;

use App\Auth0\Infrastructure\Auth0User;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class IndexTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    #[Test]
    public function it_can_view_page(): void {

        $this->client->loginUser(
            new Auth0User(
                'test@test.nl',
                [
                    'ROLE_USER'
                ],
                new DateTimeImmutable()
            )
        );


        $this->client->request('POST', '/');

        self::assertPageTitleSame('Symfony Blog');
    }
}