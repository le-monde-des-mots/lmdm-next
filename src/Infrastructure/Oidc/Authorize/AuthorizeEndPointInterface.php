<?php

namespace LmdmNext\Infrastructure\Oidc\Authorize;

use LmdmNext\Domain\Oidc\Client\ClientRepositoryInterface;
use LmdmNext\Infrastructure\IEndPoint;

interface AuthorizeEndPointInterface extends IEndPoint
{
    public function __construct(ClientRepositoryInterface $clientRepository);
}