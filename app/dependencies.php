<?php

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//Twig
$container['view'] = function ($container) {
    $settings = $container->get('settings')['twig'];
    $view = new \Slim\Views\Twig($settings['views_path'], [
        'cache' => $settings['cache_path']
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    return $view;
};

//DB
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setFetchMode(PDO::FETCH_ASSOC);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};

//Flash Messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

?>