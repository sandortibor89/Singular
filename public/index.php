<?php
declare(strict_types=1);

if (version_compare(PHP_VERSION, '7.3', '<')) {
    die("Upgrade your PHP version (".PHP_VERSION.") to 7.3 or newer!");
}

session_start();

date_default_timezone_set('Europe/Budapest');

define('DS', DIRECTORY_SEPARATOR);
define('PUBLIC_DIR', __DIR__);
define('ROOT_DIR', dirname(PUBLIC_DIR, 1));
define('APP_DIR', ROOT_DIR.DS.'app');
define('CORE_DIR', ROOT_DIR.DS.'core');
define('VENDOR_DIR', ROOT_DIR.DS.'vendor');

require_once CORE_DIR.DS.'init.php';
?>