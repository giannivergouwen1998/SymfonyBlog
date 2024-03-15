<?php

namespace App;

use App\Controller\BlogController;
use App\Router\Method;
use App\Router\Router;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\Routing\RouteCollection;
use const EXTR_IF_EXISTS;
use const EXTR_SKIP;

final class App
{
    public function run()
    {
        $request = Request::createFromGlobals();

        $routes = new RouteCollection();
        $routes->add('get', new Routing\Route(
            '/',
            defaults: [
                '_controller' => function (Request $request): Response {
                    // $foo will be available in the template
//                    $request->attributes->set('Title', 'Hoi');

                    $response = $this->render_template($request);

                    // change some header
                    $response->headers->set('Content-Type', 'text/html; charset=utf-8');

                    return $response;
                }

            ],
            methods: ['get']));

        $context = new Routing\RequestContext();
        $context->fromRequest($request);
        $matcher = new Routing\Matcher\UrlMatcher($routes, $context);

        try {
            $request->attributes->add($matcher->match($request->getPathInfo()));
            $response = call_user_func($request->attributes->get('_controller'), $request);
        } catch (Routing\Exception\ResourceNotFoundException $exception) {
            $response = new Response('Not Found', 404);
        } catch (Exception $exception) {
            $response = new Response('An error occurred', 500);
        }

        $response->send();
    }

    function render_template(Request $request): Response
    {
        extract($request->attributes->all(), EXTR_SKIP);
        ob_start();
        include sprintf(__DIR__.'/../templates/%s.html', $_route);

        return new Response(ob_get_clean());
    }
}

