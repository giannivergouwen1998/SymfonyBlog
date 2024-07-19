<?php

declare(strict_types = 1);

use App\App;
use App\Config\DiContainer;
use App\Controller\PageController;
use App\Router\Method;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$container = new ContainerBuilder();

$container->register(
    RouteCollection::class,
    RouteCollection::class
)->addMethodCall(
    'add',
    [
        'index',
        new Route(
            '/',
            defaults: [
                '_controller' => PageController::class."::viewIndex"
            ],
            methods: [Method::GET->value]
        )
    ]
);

$container->register(
    RequestContext::class,
    RequestContext::class
);

$container->register(
    UrlMatcher::class,
    UrlMatcher::class
)->addArgument(
    new \Symfony\Component\DependencyInjection\Reference(
        RouteCollection::class
    )
)->addArgument(
    new \Symfony\Component\DependencyInjection\Reference(
        RequestContext::class
    )
);

$container->register(
    App::class
)->addArgument(
    new \Symfony\Component\DependencyInjection\Reference(RequestContext::class)
)->addArgument(
    new \Symfony\Component\DependencyInjection\Reference(UrlMatcher::class)
);

return $container;
