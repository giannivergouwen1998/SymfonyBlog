<?php

namespace App;

use App\Router\Method;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function dump;

final class AppTest extends TestCase
{
    protected function setUp(): void
    {
        $request = new Request();
        $request->setMethod('GET');

    }

    #[Test]
    public function it_can_return_a_response(): void {
        $app = new App();
        $actual = $app->run();


        self::assertSame(<<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Title</title>
        </head>
        <body>
        <h1>Hoi</h1>
        
        <form method="post" action="/post">
            <label for="title">Titel:</label>
            <input type="text" id="title"/><br><br>
            <label for="text">Tekst:</label><br><br>
            <textarea id="text"></textarea>
            <input type="submit" value="Post"/>
        </form>
        </body>
        </html>
        HTML

 , $actual->getContent());
    }
}