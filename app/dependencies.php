<?php
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Monolog\Handler\StreamHandler;
use Psr\Container\ContainerInterface;

$containerBuilder->addDefinitions([
    'logger' => function (ContainerInterface $c) {
        $loggerSettings = $c->get('settings')['logger'];
        $logger = new Logger($loggerSettings['name']);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($loggerSettings['path'], $loggerSettings['level']));
        return $logger;
    }
]);
?>