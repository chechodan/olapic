<?php
namespace Olapic\SocialMedia;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;

/**
 * This class was created for the purpose of illustrating the pattern strategy.
 * The main 'getLocation' method returns an exception showing implementation
 * error. Besides the class is used to contain utility functions that help us to
 * get more information about the location.
 *
 * @package \Olapic\SocialMedia
 * @copyright 2015 Sergio Liendo
 * @see \Olapic\SocialMedia\SoialMediaInterface
 * @author Sergio Liendo
 *        
 */
class FacebookSocialMedia implements SocialMediaInterface
{

    /**
     * Constant representing the key parameter in the argument list.
     *
     * @var string PARAM_ACCESS_TOKEN
     */
    const PARAM_ACCESS_TOKEN = "facebook_access_token";

    /**
     * Constant representing an error message.
     *
     * @var string MESSAGE_NOT_IMPLEMENTED
     */
    const MESSAGE_NOT_IMPLEMENTED = "Not implemented.";

    /**
     * Argument list.
     *
     * @var array $arg
     */
    private $arg;

    /**
     * The constructor.
     *
     * @param array $arg
     *            Argument list
     */
    public function __construct($arg)
    {
        $this->arg = $arg;
    }

    /**
     * Not implemented with facebook.
     * The method returns an exception showing implementation error.
     *
     * @param string $media_id The media id
     * @param array $arg Argument list
     * @return array|false The location information
     * @see \Olapic\SocialMedia\SocialMediaInterface::getLocation()
     */
    public function getLocation($media_id, $arg = false)
    {
        $arg = ($arg) ? $arg : $this->arg;
        $access_token = $arg[self::PARAM_ACCESS_TOKEN];
        
        throw new \Exception(self::MESSAGE_NOT_IMPLEMENTED);
        
        return false;
    }

    /**
     * The method uses the facebook api to get more information regarding a
     * location.
     *
     * @param number $lat
     *            Latitude
     * @param number $lng
     *            Longitude
     * @param string $access_token
     *            Access token provided by the social network
     * @param string $name
     *            Location description. The default is empty
     * @param number $limit
     *            Amount of locations to return. The default is 1
     * @param number $distance
     *            The maximum distance of each location, with respect to
     *            latitude and longitude. The default is 100
     * @return mixed|false The locations
     */
    public static function searchLocation($lat, $lng, $access_token, $name = '', 
        $limit = 1, $distance = 100)
    {
        $name = "q=" . urlencode($name);
        $type = "type=place";
        $limit = "limit=" . urlencode($limit);
        $distance = "distance=" . urlencode($distance);
        $center = "center=" . urlencode($lat . "," . $lng);
        $access_token = "access_token=" . urlencode($access_token);
        $lt = "&";
        $url = "https://graph.facebook.com/search?" . $name . $lt . $type . $lt .
             $center . $lt . $limit . $lt . $distance . $lt . $access_token;
        $location = false;
        
        try {
            $location = json_decode(file_get_contents($url));
        } catch (\Exception $ex) {}
        
        return $location;
    }

    /**
     * The method obtains information about the first found location.
     * The detail of the location is given by:
     *
     * - street
     * - city
     * - state
     * - country
     * - zip
     * - latitude
     * - longitude
     *
     * @param number $lat
     *            Latitude
     * @param number $lng
     *            Longitude
     * @param string $access_token
     *            Access token provided by the social network
     * @param string $name
     *            Location description. The default is empty
     * @param number $distance
     *            The maximum distance of each location, with respect to
     *            latitude and longitude. The default is 100
     * @return array The location information
     */
    public static function getLocationInfo($lat, $lng, $access_token, $name = '', 
        $distance = 100)
    {
        $location = self::searchLocation($lat, $lng, $access_token, $name, 1, 
            $distance);
        
        $geopoint = array(
            "latitude" => $lat,
            "longitude" => $lng
        );
        $result = array(
            "geopoint" => $geopoint
        );
        
        if ($location && isset($location->data[0]->location)) {
            $location = $location->data[0]->location;
            $result = array(
                "street" => $location->street,
                "city" => $location->city,
                "state" => $location->state,
                "country" => $location->country,
                "zip" => $location->zip,
                "latitude" => $location->latitude,
                "longitude" => $location->longitude,
                "geopoint" => $geopoint
            );
        }
        
        return $result;
    }
}

?>
