<?php
declare(strict_types=1);

// Files
$files = [
    'composer_autoload' => VENDOR_DIR.DS.'autoload.php',
    'whoops'            => CORE_DIR.DS.'whoops.php',
    'routes'            => APP_DIR.DS.'routes.php'
];

// Composer load
if (!file_exists($files['composer_autoload'])) {
    die('The composer autoload file ('.$files['composer_autoload'].') not exists.');
}
require_once $files['composer_autoload'];

// Whoops load
if (!file_exists($files['whoops'])) {
    die('The whoops file ('.$files['whoops'].') not exists.');
}
require_once $files['whoops'];

/* FastRoute - start */
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/users', 'get_all_users_handler');
    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $handler->addDataTable('404 Page not found', [
            'url' => 'as'
        ]);
        throw new Exception("Singular application error");
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo "405";
        echo $allowedMethods;
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        var_dump($vars);
        // ... call $handler with $vars
        break;
}
/* FastRoute - end */
?>