<?php

namespace LmdmNext\Infrastructure\Oidc;

use LmdmNext\Infrastructure\Oidc\Authorize\AuthorizeEndPoint;
use LmdmNext\Infrastructure\Oidc\Authorize\AuthorizeEndPointInterface;
use Slim\Routing\RouteCollectorProxy;

class OidcRouter implements OidcRouterInterface
{

    public function __invoke(RouteCollectorProxy $group): void
    {
        $group->get("/authorize", $this->authorizeEndPoint);
    }

    public function __construct(private AuthorizeEndPointInterface $authorizeEndPoint)
    {
    }
}
