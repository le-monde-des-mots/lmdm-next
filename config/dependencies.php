<?php

use DI\ContainerBuilder;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Setup;
use LmdmNext\Application\Settings\Settings;
use LmdmNext\Domain\Auth\User\UserRepositoryInterface;
use LmdmNext\Domain\Oidc\Client\ClientRepositoryInterface;
use LmdmNext\Infrastructure\Api\ApiRouter;
use LmdmNext\Infrastructure\Api\ApiRouterInterface;
use LmdmNext\Infrastructure\Auth\AuthRouteInterface;
use LmdmNext\Infrastructure\Auth\AuthRouter;
use LmdmNext\Infrastructure\Auth\Signin\SigninEndPoint;
use LmdmNext\Infrastructure\Auth\Signin\SigninEndPointInterface;
use LmdmNext\Infrastructure\Auth\Signin\SigninFormFormEndPoint;
use LmdmNext\Infrastructure\Auth\Signin\SigninFormEndPointInterface;
use LmdmNext\Infrastructure\Auth\User\DBUserRepository;
use LmdmNext\Infrastructure\Oidc\Authorize\AuthorizeEndPoint;
use LmdmNext\Infrastructure\Oidc\Authorize\AuthorizeEndPointInterface;
use LmdmNext\Infrastructure\Oidc\Client\DBClientRepository;
use LmdmNext\Infrastructure\Oidc\OidcRouterInterface;
use LmdmNext\Infrastructure\Oidc\OidcRouter;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

return function (ContainerBuilder &$builder) {
    $builder->addDefinitions([
        EntityManagerInterface::class => function (ContainerInterface $container) {
            /** @var Settings $settings */
            $settings = $container->get("doctrine");
            // Use the ArrayAdapter or the FilesystemAdapter depending on the value of the 'dev_mode' setting
            // You can substitute the FilesystemAdapter for any other cache you prefer from the symfony/cache library
            $cache = $settings['dev_mode'] ?
                DoctrineProvider::wrap(new ArrayAdapter()) :
                DoctrineProvider::wrap(new FilesystemAdapter(directory: $settings['cache_dir']));

            $config = ORMSetup::createAttributeMetadataConfiguration(
                $settings['metadata_dirs'],
                $settings['dev_mode'],
                null,
                $cache
            );

            return EntityManager::create($settings['connection'], $config);

        },
        ClientRepositoryInterface::class => DI\autowire(DBClientRepository::class),
        UserRepositoryInterface::class => DI\autowire(DBUserRepository::class),
        OidcRouterInterface::class => DI\autowire(OidcRouter::class),
        AuthorizeEndPointInterface::class => DI\autowire(AuthorizeEndPoint::class),
        ApiRouterInterface::class => DI\autowire(ApiRouter::class),
        AuthRouteInterface::class => DI\autowire(AuthRouter::class),
        SigninFormEndPointInterface::class => DI\autowire(SigninFormFormEndPoint::class),
        SigninEndPointInterface::class => DI\autowire(SigninEndPoint::class)
    ]);
};