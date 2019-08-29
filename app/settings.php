<?php
use Monolog\Logger;
return [
    'settings' => [
        'displayErrorDetails' => true,
        'logger' => [
            'name' => 'singular',
            'path' => APP_DIR.DS.'logs'.DS.'app.log',
            'level' => Logger::DEBUG
        ],
        'twig' => [
            'views_path' => APP_DIR.DS.'resources'.DS.'views',
            //'cache_path' => APP_DIR.DS.'cache'.DS.'twig'
            'cache_path' => false
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'dbname',
            'username' => 'user',
            'password' => 'pass',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => ''
        ]
    ],
];
?>
