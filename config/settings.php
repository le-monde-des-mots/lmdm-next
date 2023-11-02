<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use LmdmNext\Application\Settings\Settings;
use LmdmNext\Application\Settings\SettingsInterface;
use Monolog\Level;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => 'php://stdout',
                    'level' => Level::Debug,
                ],
            ]);
        }
    ]);
};