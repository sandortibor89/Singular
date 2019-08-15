<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteContext;

$composer_autoload = ROOT_DIR.DS.'vendor'.DS.'autoload.php';

if (!file_exists($composer_autoload)) {
    die('The composer autoload file ('.$composer_autoload.') load failed.');
}

require_once $composer_autoload;

$containerBuilder = new ContainerBuilder();

$settings = require_once APP_DIR.DS.'settings.php';
$settings($containerBuilder);

AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

$app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello World!");
    return $response;
});

$app->run();
?>