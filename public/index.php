<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use LmdmNext\Infrastructure\Api\ApiRouterInterface;
use LmdmNext\Infrastructure\Auth\AuthRouteInterface;
use LmdmNext\Infrastructure\Oidc\OidcRouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Error\LoaderError;
use Twig\Extension\DebugExtension;

define("APP_ROOT", dirname(__DIR__, 1));
const SEP = DIRECTORY_SEPARATOR;
const CONFIG_DIR = APP_ROOT . SEP . "config";
const TEMPLATES_DIR = APP_ROOT . SEP . "templates";

require APP_ROOT . SEP . "vendor" . SEP . "autoload.php";

$containerBuilder = new ContainerBuilder();
$settings = require CONFIG_DIR . SEP . "settings.php";
$settings($containerBuilder);
$dependencies = require CONFIG_DIR . SEP . "dependencies.php";
$dependencies($containerBuilder);
try {

    $container = $containerBuilder->build();
    AppFactory::setContainer($container);
    $app = AppFactory::create();

    try {

        $twig = Twig::create(TEMPLATES_DIR, ['cache' => false, 'debug' => true]);
        $twig->addExtension(new DebugExtension());
        $app->add(TwigMiddleware::create($app, $twig));
        $app->addRoutingMiddleware();
        $errorMiddleware = $app->addErrorMiddleware(true, true, true);

        $app->get("/", function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
            $view = Twig::fromRequest($request);
            return $view->render($response, 'home.twig', []);
        });
        $app->get("/phpinfo", function (ServerRequestInterface $request, ResponseInterface $response, array $args){
            ob_start();
            phpinfo();
            $variable = ob_get_contents();
            ob_get_clean();
            $response->getBody()->write($variable);
            return $response;
        });
        $app->group("/oidc", $container->get(OidcRouterInterface::class));
        $app->group("/api", $container->get(ApiRouterInterface::class));
        $app->group("/auth", $container->get(AuthRouteInterface::class));

        $app->run();

    } catch (LoaderError $e) {
        die("Error on templates initialization");
    }

} catch (Exception $e) {
    var_dump($e);
    die("Error on building container");
}


