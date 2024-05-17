<?php
require_once dirname(__DIR__).'/vendor/autoload.php';

use App\App;
use App\Config\DiContainer;
use App\Controller\PageController;
use App\Router\Method;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$container = new DiContainer();

$container->set(RouteCollection::class, function (){
    $routes = new RouteCollection();

    $pageController = PageController::class;

    $routes->add(
        'index',
        new Route(
            '/',
            defaults: [
                '_controller' => "{$pageController}::viewIndex"
            ],
            methods: [Method::GET->value]
        )
    );

    return $routes;
});

$container->set(RequestContext::class, function () {
    return new RequestContext();
});

$container->set(UrlMatcher::class, function (DiContainer $container){
    $routeCollection = $container->get(RouteCollection::class);
    $context = $container->get(RequestContext::class);

    return new UrlMatcher($routeCollection, $context);
});

$context = $container->get(RequestContext::class);
$matcher = $container->get(UrlMatcher::class);

(new App(
    $context,
    $matcher,
))->run();