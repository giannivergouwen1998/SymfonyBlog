<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework, ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'messenger' => [
            'transports' => null,
            'routing' => null,
        ],
//        'when@test' => [
//            'framework' => [
//                'messenger' => [
//                    'transports' => [
//                        'async' => 'in-memory://',
//                    ],
//                ],
//            ],
//        ],
    ]);
};
