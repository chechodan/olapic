<?php

namespace Olapic\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Olapic\SocialMedia\SocialMedia;

class MediaControllerProvider implements ControllerProviderInterface {
    public function connect(Application $app) {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/{media_id}', function (Application $app, Request $request, $media_id) {
          $arg["access_token"] = $request->query->get('access_token');
          $arg["network"] = $request->query->get('network');
          $social_media = new SocialMedia($arg); 
          $location = $social_media->getLocation($media_id);
          
          return ($location) ? $app->json($location, 200) : $app->json(array('message' => 'The location was not found.'), 404);          
        });

        return $controllers;
    }
}

?>
