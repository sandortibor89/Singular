<?php
declare(strict_types=1);

// Files
$files = [
    'composer' => VENDOR_DIR.DS.'autoload.php',
    'whoops'            => CORE_DIR.DS.'whoops.php',
    'system'            => CORE_DIR.DS.'system.php'
];

// Composer load
if (!file_exists($files['composer'])) {
    die('The composer file ('.$files['composer'].') not exists.');
}
require_once $files['composer'];

// System load
if (!file_exists($files['system'])) {
    die('The system file ('.$files['system'].') not exists.');
}
require_once $files['system'];

spl_autoload_register(function ($originalclass) {
	$explode = explode('\\', $originalclass);
	$class = strtolower(array_pop($explode));
	if (count($explode) === 1 && in_array(reset($explode), ['model','controller'])) {
		$directory = APP_SUB_DIR;
	} else {
		$directory = ROOT_DIR;
	}
	array_walk($explode, function(&$item, $key) {
		$item = (!in_array($item, ['core','system'])) ? $item.'s' : $item;
	});
	$namespace = implode(DS, $explode);
	$directory .= DS.$namespace;
	$_class = $directory.DS.$class.'.php';
    \core\System::require($_class);
});

\core\System::router();

die;

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