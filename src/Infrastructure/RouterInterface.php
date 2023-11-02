<?php

namespace LmdmNext\Infrastructure;

use Slim\Interfaces\RouteGroupInterface;
use Slim\Routing\RouteCollectorProxy;

interface RouterInterface
{
    public function __invoke(RouteCollectorProxy $group);
}