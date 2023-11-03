<?php

namespace LmdmNext\Infrastructure\Auth;

use LmdmNext\Infrastructure\Auth\AuthRouteInterface;
use LmdmNext\Infrastructure\Auth\Signin\SigninEndPointInterface;
use LmdmNext\Infrastructure\Auth\Signin\SigninFormEndPointInterface;
use Slim\Routing\RouteCollectorProxy;

class AuthRouter implements AuthRouteInterface
{

    public function __invoke(RouteCollectorProxy $group): void
    {
        $group->get("/signin", $this->signinFormEndPoint)->setName("signinForm");
        $group->post("/signin", $this->signinEndPoint)->setName("signinPost");
    }

    public function __construct(private SigninFormEndPointInterface $signinFormEndPoint,
                                private SigninEndPointInterface $signinEndPoint) {

    }
}