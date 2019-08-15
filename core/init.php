<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

session_start();

date_default_timezone_set('Europe/Budapest');

define('APP_DIR', ROOT_DIR.DS.'app');

$composer_autoload = ROOT_DIR.DS.'vendor'.DS.'autoload.php';

if (!file_exists($composer_autoload)) {
    die('The composer autoload file ('.$composer_autoload.') load failed.');
}

require_once $composer_autoload;

class_alias('\core\Model', '\app\models\Model');
class_alias('\core\Controller', '\app\controllers\Controller');
class_alias('\core\Middleware', '\app\middlewares\Middleware');

$app = new \Slim\App(require_once APP_DIR.DS.'settings.php');

$container = $app->getContainer();

require_once APP_DIR.DS.'dependencies.php';

$autoload_arrays = ['middlewares','controllers','models'];

foreach ($autoload_arrays as $v) {

    if (file_exists(APP_DIR.DS.$v)) {

        foreach (array_diff(scandir(APP_DIR.DS.$v), ['.', '..']) as $vv) {

            $filename = pathinfo($vv, PATHINFO_FILENAME);
            $class = '\app\\'.$v.'\\'.$filename;
        
            $container[$filename] = function ($container) use ($class) {
                return new $class($container);
            };
        
        }

    }

}

require_once APP_DIR.DS.'routes.php';

$app->run();
?>