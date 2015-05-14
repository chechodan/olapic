<?php

require_once __DIR__.'/../vendor/autoload.php';
 
$app = new Silex\Application();

$app['debug'] = false;

$app->get('/', function () use($app) {
  return $app->redirect('/media');
});
  
$app->mount('/media', new Olapic\Controller\MediaControllerProvider()); 

$access_token = false;   

try {
  $access_token = trim(file_get_contents(__DIR__.'/../config/access_token.key'));
} catch(\Exception $ex) { }

$app["access_token"] = $access_token;

return $app;

?>
