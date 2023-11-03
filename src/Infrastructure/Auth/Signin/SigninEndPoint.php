<?php

namespace LmdmNext\Infrastructure\Auth\Signin;

use LmdmNext\Domain\Auth\User\UserRepositoryInterface;
use LmdmNext\Infrastructure\Auth\Signin\SigninEndPointInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SigninEndPoint implements SigninEndPointInterface
{

    public function __construct(private UserRepositoryInterface $userRepository) {

    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $form = (array)$request->getParsedBody();
        $username = $form["username"];
        $password = $form["password"];
        if(!$this->userRepository->checkPasswordCredentials($username,$password)) {
            $response->getBody()->write( "error");
            return $response;
        } else {
            $response->getBody()->write( "ok");
            return $response;        }
    }
}