<?php

namespace LmdmNext\Infrastructure\Oidc\Authorize;

use LmdmNext\Domain\Oidc\Client\ClientRepositoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class AuthorizeEndPoint implements AuthorizeEndPointInterface
{
    public function __construct(private ClientRepositoryInterface $clientRepository) {
    }
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $clientId = $request->getQueryParams()["client_id"]??false;
        $redirectUri = $request->getQueryParams()["redirect_uri"]??false;
        $codeChallenge = $request->getQueryParams()["code_challenge"]??false;
        $scope = $request->getQueryParams()["scope"]??false;
        $query = $request->getUri()->getQuery();
        $scheme = $request->getUri()->getScheme();
        $host = $request->getUri()->getHost();
        $port = $request->getUri()->getPort();
        $p = $port?':'.$port:'';
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $pathEndPoint = $routeParser->urlFor('signinForm');

        if(!($clientId && $redirectUri && $codeChallenge && $scope)
            || !(str_contains($scope, "openid") && str_contains($scope,"profile") && str_contains($scope, "userinfo")))
        {
            $content = ["error" => "invalid request"];
            $response->getBody()->write(json_encode($content));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        if(!$this->clientRepository->verifyClientInfo($clientId, $redirectUri)) {
            $content = ["error" => "invalid client"];
            $response->getBody()->write(json_encode($content));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }
        $uri = $request->getUri();

     return $response
            ->withHeader("Location", "$scheme://$host$p$pathEndPoint?$query")
            ->withStatus(302);
    }
}