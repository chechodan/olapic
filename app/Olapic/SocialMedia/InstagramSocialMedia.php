<?php

namespace Olapic\SocialMedia;

use Instagram\Instagram;

class InstagramSocialMedia implements SocialMediaInterface 
{
    const PARAM_ACCESS_TOKEN = "instagram_access_token";
  
    private $arg;

    public function __construct($arg)
    {
        $this->arg = $arg;
    }

    public function getLocation($media_id, $arg = false)
    {
        $arg = ($arg) ? $arg : $this->arg;
        $result = false;
        $access_token = isset($arg[self::PARAM_ACCESS_TOKEN]) ? 
                              $arg[self::PARAM_ACCESS_TOKEN] : false;

        $instagram = new Instagram();        
        $instagram->setAccessToken($access_token);

        $media = $instagram->getMedia($media_id);

        if ($media && $media->hasLocation()) {
            $location = $media->getLocation(true);
            $lat = $location->getLat();
            $lng = $location->getLng();      
            $name = $location->getName();

            $place = FacebookSocialMedia::getLocationInfo(
                                $lat, 
                                $lng, 
                                $arg[FacebookSocialMedia::PARAM_ACCESS_TOKEN], 
                                $name, 
                                1, 
                                300
                     );

            $result = array('id' => $media_id, 'location' => $place);
        } 
        
        return $result;
    } 
}

?>
