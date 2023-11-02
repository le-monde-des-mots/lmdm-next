<?php

namespace LmdmNext\Infrastructure\Oidc;

use LmdmNext\Infrastructure\Oidc\Authorize\AuthorizeEndPointInterface;
use LmdmNext\Infrastructure\RouterInterface;

interface OidcRouterInterface extends RouterInterface
{
    public function __construct(AuthorizeEndPointInterface $authorizeEndPoint);
}