<?php
require_once dirname(__DIR__).'/vendor/autoload.php';
use App\App;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$container = require dirname(__DIR__) . '/config/init.php';

$context = $container->get(RequestContext::class);
$matcher = $container->get(UrlMatcher::class);

(new App(
    $context,
    $matcher,
))->run();