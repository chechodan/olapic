<?php

require_once __DIR__.'/../vendor/autoload.php';
 
$app = new Silex\Application();

$app['debug'] = true;
  
$app->mount('/media', new Olapic\Controller\MediaControllerProvider()); 
 
$app->run();

?>
