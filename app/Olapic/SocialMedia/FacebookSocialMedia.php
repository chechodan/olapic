<?php

namespace Olapic\SocialMedia;

use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class FacebookSocialMedia implements SocialMediaInterface 
{
    const PARAM_ACCESS_TOKEN = "facebook_access_token";
    const MESSAGE_NOT_IMPLEMENTED = "Not implemented.";

    private $arg;

    public function __construct($arg) 
    {
        $this->arg = $arg;
    }

    public function getLocation($media_id, $arg = false)
    {
        $arg = ($arg) ? $arg : $this->arg;
        $access_token = $arg[self::PARAM_ACCESS_TOKEN];

        throw new \Exception(self::MESSAGE_NOT_IMPLEMENTED);

        return false;
    } 

    public static function getLocationInfo(
                                        $lat, 
                                        $lng, 
                                        $access_token, 
                                        $name='', 
                                        $limit=1, 
                                        $distance=100
    ) {  
        $name = "q=".$name;
        $type = "type=place";
        $limit = "limit=".$limit;
        $distance = "distance=".$distance;
        $center = "center=".$lat.",".$lng;
        $access_token = "access_token=".$access_token;
        $lt = "&";
        
        $location = false;
        try {
            $location = json_decode(file_get_contents(
                      "https://graph.facebook.com/search?".$name.$lt.$type.$lt.
                      $center.$lt.$limit.$lt.$distance.$lt.$access_token
            ));
        } catch (\Exception $ex) {
        }

        $geopoint = array("latitude" => $lat, "longitude" => $lng); 
        $result = array("geopoint" => $geopoint);
        
        if ($location && isset($location->data[0]->location)) {
            $location = $location->data[0]->location;
            $result = array(
                          "street"    => $location->street, 
                          "city"      => $location->city, 
                          "state"     => $location->state, 
                          "country"   => $location->country, 
                          "zip"       => $location->zip, 
                          "latitude"  => $location->latitude, 
                          "longitude" => $location->longitude, 
                          "geopoint"  => $geopoint
                       );
        }

        return $result;
    }
}

?>
