<?php

namespace LmdmNext\Infrastructure\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteCollectorProxy;

class ApiRouter implements ApiRouterInterface
{
    public function __invoke(RouteCollectorProxy $group): void
    {
        $group->get("/tags", function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
            $response->getBody()->write("Tags!");
            return $response;
        });
    }
}