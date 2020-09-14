<?php

/*=================================
 * FRONT CONTROLLER
=================================*/
session_start();

require __DIR__ . '/../vendor/autoload.php';

use MVC\Service\Environment;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Server\RequestHandlerInterface;

$env = new Environment();
$env->setSession();

if(isset($_SERVER['PATH_INFO'])){
    $pathArray=explode("/", $_SERVER['PATH_INFO']);
    $path = $pathArray[1];
}elseif(isset($_SERVER['ORIG_PATH_INFO'])){
    $pathArray=explode("/", $_SERVER['ORIG_PATH_INFO']);
    $path = $pathArray[1];
}else{
    $path = null;
}

$rote = require __DIR__ . '/../config/routes/routes.php';
if(!array_key_exists($path, $rote)){
    $path='404';
}

$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();
$controllClass = $rote[$path];
/** @var RequestHandlerInterface $controlador */
$controll = new $controllClass();
$response = $controll->handle($request);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
