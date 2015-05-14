<?php

namespace Olapic\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Olapic\SocialMedia\SocialMedia;

class MediaControllerProvider implements ControllerProviderInterface {
  const MESSAGE_LOCATION_NOT_FOUND   = "The location was not found.";
  const MESSAGE_MEDIA_ID_NOT_FOUND   = "The media id was not found."; 

  public function connect(Application $app) {
    // creates a new controller based on the default route
    $controllers = $app['controllers_factory'];

    $controllers->get('/', "Olapic\\Controller\\MediaControllerProvider::index");

    $controllers->get('/{media_id}',  "Olapic\\Controller\\MediaControllerProvider::getLocation");

    return $controllers;
  }

  function index(Application $app) {
    return $app->json(array("message" => self::MESSAGE_MEDIA_ID_NOT_FOUND), 404);
  }

  function getLocation(Application $app, Request $request, $media_id) {
    $access_token = trim($request->query->get('access_token'));
    $arg["access_token"] = ($access_token) ? $access_token : $app["access_token"];
    $arg["network"] = $request->query->get('network');
    $msg = self::MESSAGE_LOCATION_NOT_FOUND;
    $location = false;
   
    try {
      $social_media = new SocialMedia($arg); 
      $location = $social_media->getLocation($media_id);
    } catch(\Exception $ex) {
      $msg = $ex->getMessage();
    }
       
    return ($location) ? $app->json($location, 200) : $app->json(array('message' => $msg), 404);  
  }    
}

?>
