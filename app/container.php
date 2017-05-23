<?php

$container = $app->getContainer();

$container['view'] = function ($container)
{
    $dir = dirname(__DIR__);
    $view = new \Slim\Views\Twig($dir.'/app/views/', [
        'cache' => false //$dir.'/tmp/cache'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['pdo'] = function (){

    $pdo = new PDO('mysql:dbname=slim3;host=localhost:8889','root','root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;

};

$container['db'] = function ($container){
    return new App\Connection\Database($container->pdo);
};

