<?php

namespace App\Router;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final readonly class Router
{
    public function __construct(
        public RouteCollection $routes,
    )
    {
    }

    public function add(string $name, string $path, RoutingOptions $options, Method $method): void
    {
        $this->routes->add($name, new Route(
            $path,
            defaults: [
                '_controller' => (string) $options,
            ],
            methods: [
                $method->value
            ]
        ));
    }
}