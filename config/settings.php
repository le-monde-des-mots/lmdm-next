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
                'doctrine' => [
                    // Enables or disables Doctrine metadata caching
                    // for either performance or convenience during development.
                    'dev_mode' => true,

                    // Path where Doctrine will cache the processed metadata
                    // when 'dev_mode' is false.
                    'cache_dir' => APP_ROOT . '/var/doctrine',

                    // List of paths where Doctrine will search for metadata.
                    // Metadata can be either YML/XML files or PHP classes annotated
                    // with comments or PHP8 attributes.
                    'metadata_dirs' => [APP_ROOT . '/src/Domain'],

                    // The parameters Doctrine needs to connect to your database.
                    // These parameters depend on the driver (for instance the 'pdo_sqlite' driver
                    // needs a 'path' parameter and doesn't use most of the ones shown in this example).
                    // Refer to the Doctrine documentation to see the full list
                    // of valid parameters: https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/configuration.html
                    'connection' => [
                        'driver' => 'pdo_mysql',
                        'host' => 'localhost',
                        'port' => 3306,
                        'dbname' => 'mydb',
                        'user' => 'user',
                        'password' => 'secret',
                        'charset' => 'utf-8'
                    ]
                ]
            ]);
        }
    ]);
};