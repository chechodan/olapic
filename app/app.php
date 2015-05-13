<?php

require_once __DIR__.'/../vendor/autoload.php';
 
$app = new Silex\Application();

$app['debug'] = false;

$app->get('/', function () use($app) {
  return $app->redirect('/media');
});
  
$app->mount('/media', new Olapic\Controller\MediaControllerProvider()); 

return $app;

?>
