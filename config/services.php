<?php

declare(strict_types=1);

use App\Auth0\Infrastructure\Auth0ConfigFactory;
use Auth0\SDK\Configuration\SdkConfiguration;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->set(SdkConfiguration::class)
        ->factory([Auth0ConfigFactory::class, 'create'])
        ->args([
            '$domain' => 'dev-xr7ehba4ynhi7dgs.us.auth0.com',
            '$cookieSecret' => '368824cc75adebd9880d39ee64057a4e',
            '$clientId' => 'RT1LhjECvzK22ZaNWFYmJpM7OZCm4HYl',
            '$clientSecret' => 'YZhbpk6evlEPmQJYhP39xmCKLSnNmAFdUFs0UDJPk8Yw7fSDclo7C0I815tZ2IPY',
        ])
    ;

    $services->load('App\\', __DIR__ . '/../src/')
        ->exclude([
        __DIR__ . '/../src/Kernel.php',
    ]);
};
