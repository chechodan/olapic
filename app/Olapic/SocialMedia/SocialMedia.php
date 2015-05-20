<?php

namespace Olapic\SocialMedia;

class SocialMedia {

  const PARAM_NETWORK="network";

  private $social_media;
  private $arg;

  public function __construct($arg) {
    $this->arg = $arg;
  }

  public function setNetwork($network){
    $this->arg[self::PARAM_NETWORK] = $network;
    unset($this->social_media); 
    
    return $this;
  }

  public function getArgument() 
  {
    return isset ($this->arg) ? $this->arg : false;
  }
  
  public function getNetwork() 
  {
    return (isset($this->arg[self::PARAM_NETWORK])) ? $this->arg[self::PARAM_NETWORK] : false;
  }

  public function getSocialMedia()
  {
    return $this->social_media;
  }

  public function getLocation($media_id, $arg = false) {
    $arg = ($arg) ? $arg : $this->arg;

    if(!isset($this->social_media)){
      $this->social_media = SocialMediaNetwork::create_social_media($arg);
    }

    return $this->social_media->getLocation($media_id, $arg);   
  }
}

?>
