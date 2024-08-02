<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\TwigConfig;

return static function (ContainerConfigurator $containerConfigurator, TwigConfig $twig): void {
    $twig->formThemes(['bootstrap_5_layout.html.twig']);

    $containerConfigurator->extension('twig', [
        'file_name_pattern' => '*.twig',
    ]);
    if ($containerConfigurator->env() === 'test') {
        $containerConfigurator->extension('twig', [
            'strict_variables' => true,
        ]);
    }
};
