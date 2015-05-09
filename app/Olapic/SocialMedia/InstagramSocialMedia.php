<?php

namespace Olapic\SocialMedia;

use Instagram\Instagram;

class InstagramSocialMedia implements SocialMediaInterface {
  private $arg;

  public function __construct($arg) {
    $this->arg = $arg;
  }

  public function getLocation($media_id, $arg = false){
    $arg = ($arg) ? $arg : $this->arg;
    $result = false;
    $access_token = isset($arg['access_token']) ? $arg['access_token'] : false;
    $instagram = new Instagram();
    $instagram->setAccessToken($access_token);
    $media = $instagram->getMedia($media_id);

    if($media && $media->hasLocation()){
      $location = $media->getLocation(true);      
      $result = array('id' => $media_id, 'location' => array('geopoint' => array('latitude' => $location->getLat(), 'longitude' => $location->getLng())));
    } 
    
    return $result;
  } 
}

?>
