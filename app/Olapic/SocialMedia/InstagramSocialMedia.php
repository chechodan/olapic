<?php
namespace Olapic\SocialMedia;

use Instagram\Instagram;

/**
 * The class is the implementation of {@link SocialMediaInterface} for instagram
 * social network.
 *
 * @package \Olapic\SocialMedia
 * @copyright 2015 Sergio Liendo
 * @see \Olapic\SocialMedia\SocialMediaInterface
 * @author Sergio Liendo
 *        
 */
class InstagramSocialMedia implements SocialMediaInterface
{

    /**
     * Constant representing the key parameter in the argument list.
     * 
     * @var string PARAM_ACCESS_TOKEN
     */
    const PARAM_ACCESS_TOKEN = "instagram_access_token";

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
     * Gets the location of the instagram object.
     * The detail of the location is given by:
     *
     * - id
     * - name description
     * - location information
     *
     * @param string $media_id The media id
     * @param array $arg Argument list
     * @return array|false The location information
     * @see \Olapic\SocialMedia\FacebookSocialMedia::getLocationInfo()
     * @see \Olapic\SocialMedia\SocialMediaInterface::getLocation()
     */
    public function getLocation($media_id, $arg = false)
    {
        $arg = ($arg) ? $arg : $this->arg;
        $result = false;
        $access_token = isset($arg[self::PARAM_ACCESS_TOKEN]) ? $arg[self::PARAM_ACCESS_TOKEN] : false;
        
        $instagram = new Instagram();
        $instagram->setAccessToken($access_token);
        
        $media = $instagram->getMedia($media_id);
        
        if ($media && $media->hasLocation()) {
            $location = $media->getLocation(true);
            $lat = $location->getLat();
            $lng = $location->getLng();
            $name = $location->getName();
            
            $place = FacebookSocialMedia::getLocationInfo($lat, $lng, 
                $arg[FacebookSocialMedia::PARAM_ACCESS_TOKEN], $name, 1, 300);
            
            $result = array(
                'id' => $media_id,
                'name' => $name,
                'location' => $place
            );
        }
        
        return $result;
    }
}

?>
