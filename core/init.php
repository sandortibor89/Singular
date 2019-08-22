<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

// Files
$files = [
    'composer_autoload' => VENDOR_DIR.DS.'autoload.php',
    'settings'          => APP_DIR.DS.'settings.php',
    'dependencies'      => APP_DIR.DS.'dependencies.php',
    'routes'            => APP_DIR.DS.'routes.php'
];

// Load composer
if (!file_exists($files['composer_autoload'])) {
    die('The composer autoload file ('.$files['composer_autoload'].') load failed.');
}
require_once $files['composer_autoload'];

// Class aliases
class_alias('\core\Controller', '\app\controllers\Controller');
class_alias('\core\Model', '\app\models\Model');

$containerBuilder = new ContainerBuilder();

// Should be set to true in production
if (false) {
    $containerBuilder->enableCompilation(APP_DIR.DS.'cache');
}

// Add settings to container
if (file_exists($files['settings'])) {
    $containerBuilder->addDefinitions(require_once $files['settings']);
}

// Load dependencies
if (file_exists($files['dependencies'])) {
    require_once $files['dependencies'];
}

// Load classes in directories
$autoload_arrays = ['controllers','models'];

foreach ($autoload_arrays as $v) {
    if (file_exists(APP_DIR.DS.$v)) {
        foreach (array_diff(scandir(APP_DIR.DS.$v), ['.', '..']) as $vv) {
            $filename = pathinfo($vv, PATHINFO_FILENAME);
            $class = '\app\\'.$v.'\\'.$filename;
            $containerBuilder->addDefinitions([
                $filename => function(Container $c) use ($class) {
                    return new $class($c);
                }
            ]);
        }
    }
}

$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Load routes
if (file_exists($files['routes'])) {
    require_once $files['routes'];
}

$app->run();
?>