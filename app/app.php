 <?php

use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = false;

$app->get('/', function () use($app) {
  return $app->redirect('/media');
});
  
$app->mount('/media', new Olapic\Controller\MediaControllerProvider()); 
 
$app[FacebookSocialMedia::PARAM_ACCESS_TOKEN]  = FACEBOOK_ACCESS_TOKEN;
$app[InstagramSocialMedia::PARAM_ACCESS_TOKEN] = INSTAGRAM_ACCESS_TOKEN;

return $app;

?>
