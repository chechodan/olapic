<?php

namespace Olapic\SocialMedia;

class FacebookSocialMedia implements SocialMediaInterface {
  private $arg;

  public function __construct($arg) {
    $this->arg = $arg;
  }

  public function getLocation($media_id, $arg = false){
    $arg = ($arg) ? $arg : $this->arg;

    throw new \Exception('Not implemented.');    

    return false;
  } 
}

?>
