<?php

if (version_compare(PHP_VERSION, '7.1', '<')) {
    die("Upgrade your PHP version (".PHP_VERSION.") to 7.1 or newer!");
}

define('DS', DIRECTORY_SEPARATOR);
define('PUBLIC_DIR', __DIR__);
define('ROOT_DIR', dirname(PUBLIC_DIR, 1));

require_once ROOT_DIR.DS.'core'.DS.'init.php';

?>