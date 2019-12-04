<?php
$run = new \Whoops\Run;
$handler = new \Whoops\Handler\PrettyPageHandler;
$handler->setPageTitle("Singular application error");
$run->pushHandler($handler);
if (\Whoops\Util\Misc::isAjaxRequest()) {
    $run->pushHandler(new \Whoops\Handler\JsonResponseHandler);
}
$run->register();
?>