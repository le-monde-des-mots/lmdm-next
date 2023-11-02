<?php
declare(strict_types=1);

namespace LmdmNext\Infrastructure\Oidc\Client;

use LmdmNext\Domain\Oidc\Client\ClientRepositoryInterface;
use Psr\Container\ContainerInterface;

class DBClientRepository implements ClientRepositoryInterface
{

    public function verifyClientInfo(string $clientId, string $redirectUrl): bool
    {
        return true;
    }

    public function __construct(ContainerInterface $container)
    {
    }
}