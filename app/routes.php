<?php
$app->get('/', 'ExampleController:index')->add('ExampleMiddleware');
?>