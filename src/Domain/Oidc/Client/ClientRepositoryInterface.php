<?php
declare(strict_types=1);

namespace LmdmNext\Domain\Oidc\Client;

use Psr\Container\ContainerInterface;

interface ClientRepositoryInterface
{
    public function __construct(ContainerInterface $container);
    public function verifyClientInfo(string $clientId, string $redirectUrl): bool;
}