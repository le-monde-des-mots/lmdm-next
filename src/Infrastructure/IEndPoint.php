<?php

namespace LmdmNext\Infrastructure;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface IEndPoint
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args);
}