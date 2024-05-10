<?php
require_once dirname(__DIR__).'/vendor/autoload.php';

use App\App;
use App\Config\DiContainer;
use App\Router\Router;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

$container = new DiContainer();

$router = $container->get(Router::class);
$context = $container->get(RequestContext::class);
$matcher = $container->get(UrlMatcher::class);

(new App(
    $router,
    $context,
    $matcher,
))->run();