<?php

namespace App\Auth0\Infrastructure;

use Auth0\SDK\Configuration\SdkConfiguration;
use Auth0\SDK\Contract\StoreInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class Auth0ConfigFactory
{
    public static function create(
        string $domain,
        string $clientId,
        string $clientSecret,
        string $cookieSecret,
        CacheItemPoolInterface $cache,
        UrlGeneratorInterface $router,
        ?StoreInterface $sessionStorage = null,
        ?StoreInterface $transientStorage = null,
    ): SdkConfiguration
    {
        return new SdkConfiguration(
            domain: $domain,
            customDomain: null,
            clientId: $clientId,
            redirectUri: 'http://localhost:80/callback',
            clientSecret: $clientSecret,
            audience: ['https://dev-xr7ehba4ynhi7dgs.us.auth0.com/api/v2/'],
            tokenCache: $cache,
            sessionStorage: $sessionStorage, // 1 week
            cookieSecret: $cookieSecret,
            cookieExpires: 60 * 60 * 24 * 7,
            cookieSecure: true,
            transientStorage: $transientStorage,
        );
    }
}