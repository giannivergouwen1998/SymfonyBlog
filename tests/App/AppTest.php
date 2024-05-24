<?php

namespace App;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

final class AppTest extends TestCase
{
    public App $app;

    protected function setUp(): void
    {
        $container = require './config/init.php';

        $context = $container->get(RequestContext::class);
        $matcher = $container->get(UrlMatcher::class);

        $request = new Request();
        $request->setMethod('GET');

        $this->app = new App($context, $matcher);

    }

    #[Test]
    public function it_can_return_a_response(): void {

        $actual = $this->app->run();


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