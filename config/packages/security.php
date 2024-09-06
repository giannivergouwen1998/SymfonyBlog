<?php

declare(strict_types=1);


use App\Auth0\Infrastructure\Auth0Authenticator;
use App\Auth0\Infrastructure\Auth0UserProvider;


use App\Auth0\UI\Controller\Auth0EntryPoint;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\SecurityConfig;

return static function (SecurityConfig $security, ContainerConfigurator $containerConfigurator): void {
    $security
        ->provider('auth0')
        ->id(Auth0UserProvider::class)
    ;

    $security
        ->firewall('main')
        ->provider('auth0')
        ->entryPoint(Auth0EntryPoint::class)
        ->customAuthenticators([
            Auth0Authenticator::class
        ])
        ->logout()
        ->target('/')
        ->path('/logout')
    ;

    $security->accessControl()
        ->path('^/')
        ->roles('ROLE_USER')
    ;

};