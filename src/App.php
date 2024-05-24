<?php

namespace App;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

final readonly class App
{
    public function __construct(
        private Routing\RequestContext $context,
        private Routing\Matcher\UrlMatcher $matcher,
    )
    {
    }

    public function run(): Response
    {
        $request = Request::createFromGlobals();

        $this->context->fromRequest($request);
        $match = $this->matcher->match($request->getPathInfo());

        try {
            $request->attributes->add($match);
            $response = call_user_func($request->attributes->get('_controller'), $request);
        } catch (Routing\Exception\ResourceNotFoundException) {
            $response = new Response('Not Found', 404);
        } catch (Exception $exception) {
            $response = new Response('An error occurred', 500);
        }

        return $response->send();
    }
}

