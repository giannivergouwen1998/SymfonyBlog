<?php

namespace App;

use App\Controller\PageController;
use App\Router\Method;
use App\Router\Router;
use App\Router\RoutingOptions;
use App\Template\TemplateEngine;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\Routing\RouteCollection;

final readonly class App
{
    public function __construct(
        private Router $router,
        private Routing\RequestContext $context,
        private Routing\Matcher\UrlMatcher $matcher,
    )
    {
    }

    public function run(): Response
    {
        $request = Request::createFromGlobals();

        $this->router->add(
            'get',
            '/',
            RoutingOptions::create(
            PageController::class,
            'viewIndex'
            ),
            Method::GET
        );

        $this->context->fromRequest($request);
        $match = $this->matcher->match($request->getPathInfo());

        try {
            $request->attributes->add($match);
            $response = call_user_func($request->attributes->get('_controller'), $request);
        } catch (Routing\Exception\ResourceNotFoundException $exception) {
            $response = new Response('Not Found', 404);
        } catch (Exception $exception) {
            $response = new Response('An error occurred', 500);
        }

        return $response->send();
    }
}

