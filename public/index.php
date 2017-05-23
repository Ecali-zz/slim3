<?php

require '../vendor/autoload.php';

$app= new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

require '../app/container.php';

$app->get('/',\App\Controllers\PageController::class . ':home');
$app->get('/test',\App\Controllers\PageController::class . ':test');
$app->get('/login',\App\Controllers\PageController::class . ':login');
$app->post('/homeback',\App\Controllers\PageController::class . ':homeback')->setName('loggato');

$app->run();