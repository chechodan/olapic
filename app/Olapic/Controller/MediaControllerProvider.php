<?php

namespace Olapic\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Olapic\SocialMedia\SocialMedia;
use Olapic\SocialMedia\SocialMediaNetwork;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

class MediaControllerProvider implements ControllerProviderInterface 
{
    const MESSAGE_LOCATION_NOT_FOUND = "The location was not found.";
    const MESSAGE_MEDIA_ID_NOT_FOUND = "The media id was not found."; 

    public function connect(Application $app) 
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get(
                     '/', 
                     "Olapic\\Controller\\MediaControllerProvider::index"
        ); 
        $controllers->get(
                     '/{media_id}', 
                     "Olapic\\Controller\\MediaControllerProvider::getLocation"
        );

        return $controllers;
    }

    function index(Application $app) 
    {
        return $app->json(array("message" => 
                     self::MESSAGE_MEDIA_ID_NOT_FOUND), 404);
    }

    function getLocation(
                       Application $app, 
                       Request $request, 
                       $media_id, 
                       $network_id = false, 
                       $access_token = false
    ) {

        $network = ($network_id) ? $network_id : 
                                   trim($request->query->get('network'));
        $access_token = ($access_token) ? $access_token : 
                                   trim($request->query->get('access_token'));

        $msg = self::MESSAGE_LOCATION_NOT_FOUND;
        $location = false;
        $arg = $this->getArguments($app, $network, $access_token);

        try {
            $social_media = new SocialMedia($arg); 
            $location = $social_media->getLocation($media_id);
        } catch (\Exception $ex) {
            $msg = $ex->getMessage();
        }
       
        return ($location) ? $app->json($location, 200) : $app->json(
                                                   array('message' => $msg),
                                                   404
                                                   );  
    }    

    protected function getArguments($app, $network, $access_token)
    { 
        $arg = array (SocialMedia::PARAM_NETWORK => $network); 

        switch ($network) {
            case SocialMediaNetwork::FACEBOOK:      
                $arg[FacebookSocialMedia::PARAM_ACCESS_TOKEN] = 
                ($access_token) ? $access_token : 
                          $app[FacebookSocialMedia::PARAM_ACCESS_TOKEN];
                break;

            case SocialMediaNetwork::INSTAGRAM:        
            default: 
                $arg[InstagramSocialMedia::PARAM_ACCESS_TOKEN] = 
                    ($access_token) ? $access_token : 
                                $app[InstagramSocialMedia::PARAM_ACCESS_TOKEN];
                $arg[FacebookSocialMedia::PARAM_ACCESS_TOKEN] = 
                    $app[FacebookSocialMedia::PARAM_ACCESS_TOKEN];
        } 
        
        return $arg;
    }
}

?>
