<?php

namespace LmdmNext\Infrastructure\Auth\Signin;

use LmdmNext\Infrastructure\Auth\Signin\SigninFormEndPointInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class SigninFormFormEndPoint implements SigninFormEndPointInterface
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $vardump = $request->getQueryParams();
        $clientId = $request->getQueryParams()["client_id"]??false;
        $redirectUri = $request->getQueryParams()["redirect_uri"]??false;
        $codeChallenge = $request->getQueryParams()["code_challenge"]??false;
        $scope = $request->getQueryParams()["scope"]??false;
        $state = $request->getQueryParams()["state"]??false;
        $view = Twig::fromRequest($request);
        return $view->render($response, 'signin.twig', [
            "client_id" => $clientId,
            "redirect_uri" => $redirectUri,
            "code_challenge" => $codeChallenge,
            "scope" => $scope,
            "state" => $state,
            "content" => $vardump
        ]);
    }
}