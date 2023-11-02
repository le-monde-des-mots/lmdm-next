<?php

use DI\ContainerBuilder;
use LmdmNext\Domain\Oidc\Client\ClientRepositoryInterface;
use LmdmNext\Infrastructure\Api\ApiRouter;
use LmdmNext\Infrastructure\Api\ApiRouterInterface;
use LmdmNext\Infrastructure\Oidc\Authorize\AuthorizeEndPoint;
use LmdmNext\Infrastructure\Oidc\Authorize\AuthorizeEndPointInterface;
use LmdmNext\Infrastructure\Oidc\Client\DBClientRepository;
use LmdmNext\Infrastructure\Oidc\OidcRouterInterface;
use LmdmNext\Infrastructure\Oidc\OidcRouter;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder &$builder) {
    $builder->addDefinitions([
        ClientRepositoryInterface::class => function (ContainerInterface $container) {
            return new DBClientRepository($container);
        },
        OidcRouterInterface::class => DI\autowire(OidcRouter::class),
        AuthorizeEndPointInterface::class => DI\autowire(AuthorizeEndPoint::class),
        ApiRouterInterface::class => DI\autowire(ApiRouter::class),
    ]);
};