<?php

require '../vendor/autoload.php';

session_start();


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
$app->get('/add/news',\App\Controllers\PageController::class . ':addNews')->setName('aggiunto');
$app->get('/home',\App\Controllers\PageController::class . ':gethomeback');
$app->get('/user/{user}',\App\Controllers\PageController::class . ':user');
$app->get('/add/video',\App\Controllers\PageController::class . ':addvideo')->setName('addvideo');
$app->get('/view/video',\App\Controllers\PageController::class . ':viewvideo');


$app->run();