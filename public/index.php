<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use LmdmNext\Infrastructure\Api\ApiRouterInterface;
use LmdmNext\Infrastructure\Oidc\OidcRouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Error\LoaderError;

define("APP_ROOT", dirname(__DIR__, 1));
const AUTOLOAD_PHP = APP_ROOT . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
const TEMPLATES_DIR = APP_ROOT . DIRECTORY_SEPARATOR . "templates";

require AUTOLOAD_PHP;

$containerBuilder = new ContainerBuilder();
$settings = require APP_ROOT . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "settings.php";
$settings($containerBuilder);
$dependencies = require APP_ROOT . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "dependencies.php";
$dependencies($containerBuilder);
try {
    $container = $containerBuilder->build();
    AppFactory::setContainer($container);
    $app = AppFactory::create();

    try {

        $twig = Twig::create(TEMPLATES_DIR, ['cache' => false]);
        $app->add(TwigMiddleware::create($app, $twig));
        $app->addRoutingMiddleware();
        $errorMiddleware = $app->addErrorMiddleware(true, true, true);

        $app->get("/", function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'home.twig', []);
        });
        $app->group("/oidc", $container->get(OidcRouterInterface::class));
        $app->group("/api", $container->get(ApiRouterInterface::class));

        $app->run();

    } catch (LoaderError $e) {
        die("Error on templates initialization");
    }

} catch (Exception $e) {
    var_dump($e);
    die("Error on building container");
}


