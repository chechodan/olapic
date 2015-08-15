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

/**
 * This class is the controller input to 'media' url.
 * The controller accepts a media id, to get the location of the object. The
 * index entry is deployed, only to display an appropriate error message.
 * 
 * @package \Olapic\Controller
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 *        
 */
class MediaControllerProvider implements ControllerProviderInterface
{

    /**
     * Constant representing an error message.
     *
     * @var string MESSAGE_LOCATION_NOT_FOUND
     */
    const MESSAGE_LOCATION_NOT_FOUND = "The location was not found.";

    /**
     * Constant representing an error message.
     *
     * @var string MESSAGE_MEDIA_ID_NOT_FOUND
     */
    const MESSAGE_MEDIA_ID_NOT_FOUND = "The media id was not found.";

    /**
     * The controller is configured to obtain the media id and then find the
     * location of the object.
     * The index is configured just to show an appropriate error.
     *
     * @param Application $app
     *            An Application instance
     * @see \Olapic\Controller\MediaControllerProvider::getLocation()
     * @see \Olapic\Controller\MediaControllerProvider::index()
     * @see \Silex\ControllerProviderInterface::connect()
     */
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];
        
        $controllers->get('/', 
            "Olapic\\Controller\\MediaControllerProvider::index");
        $controllers->get('/{media_id}', 
            "Olapic\\Controller\\MediaControllerProvider::getLocation");
        
        return $controllers;
    }

    /**
     * The index is configured just to show an appropriate error.
     *
     * @param Application $app
     *            An Application instance
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Application $app)
    {
        return $app->json(
            array(
                "message" => self::MESSAGE_MEDIA_ID_NOT_FOUND
            ), 404);
    }

    /**
     * Find the location of the object.
     *
     * @param Application $app
     *            An Application instance
     * @param Request $request
     *            A Request instance
     * @param string $media_id
     *            The media id
     * @param string $network_id
     *            The type of social network related, for example 'facebook' or
     *            'instragram'
     * @param string $access_token
     *            Access token provided by the social network
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getLocation(Application $app, Request $request, $media_id, 
        $network_id = false, $access_token = false)
    {
        $network = ($network_id) ? $network_id : trim(
            $request->query->get('network'));
        $access_token = ($access_token) ? $access_token : trim(
            $request->query->get('access_token'));
        
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
            array(
                'message' => $msg
            ), 404);
    }

    /**
     * Prepare a list of arguments required for the location of the object.
     *
     * @param Application $app
     *            An Application instance
     * @param string $network
     *            The type of social network related, for example 'facebook' or
     *            'instragram'
     * @param string $access_token
     *            Access token provided by the social network
     * @return array Argument list
     */
    protected function getArguments(Application $app, $network, $access_token)
    {
        $arg = array(
            SocialMedia::PARAM_NETWORK => $network
        );
        
        switch ($network) {
            case SocialMediaNetwork::FACEBOOK:
                $arg[FacebookSocialMedia::PARAM_ACCESS_TOKEN] = ($access_token) ? $access_token : $app[FacebookSocialMedia::PARAM_ACCESS_TOKEN];
                break;
            
            case SocialMediaNetwork::INSTAGRAM:
            default:
                $arg[InstagramSocialMedia::PARAM_ACCESS_TOKEN] = ($access_token) ? $access_token : $app[InstagramSocialMedia::PARAM_ACCESS_TOKEN];
                $arg[FacebookSocialMedia::PARAM_ACCESS_TOKEN] = $app[FacebookSocialMedia::PARAM_ACCESS_TOKEN];
        }
        
        return $arg;
    }
}

?>
