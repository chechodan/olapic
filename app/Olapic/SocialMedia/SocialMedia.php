<?php

namespace Olapic\SocialMedia;

class SocialMedia {

  private $social_media;
  private $arg;

  public function __construct($arg) {
    $this->arg = $arg;
  }

  public function setNetwork($network){
    $this->arg['network'] = $network;
    unset($this->social_media); 
    
    return $this;
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
