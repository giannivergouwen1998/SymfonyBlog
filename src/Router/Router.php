<?php

namespace App\Router;

use App\Controller\BlogController;
use Closure;
use Exception;
use function var_dump;

class Router
{
    protected $routes = [];

    public function addRoute(Method $method, string $url, closure $target)
    {
        $this->routes[$method->value][$url] = $target;
    }

    public function matchRoute(Request $request): Response
    {
        if (isset($this->routes[$request->getMethod()->value])) {
            foreach ($this->routes[$request->getMethod()->value] as $routeUrl => $target) {
                if ($routeUrl == $request->getPath()) {
                    return call_user_func($target, $request);
                }
            }
        }
        throw new Exception('Route not found');
    }
}