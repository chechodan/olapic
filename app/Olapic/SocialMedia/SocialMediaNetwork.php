<?php

namespace Olapic\SocialMedia;

class SocialMediaNetwork {
  const INSTAGRAM = "instragram";
  const FACEBOOK = "facebook";

  static public function create_social_media($arg) {
    $social_media = false;
    $network = isset($arg['network']) ? $arg['network'] : false;
 
    switch($network) {
      case self::FACEBOOK:
        $social_media = new FacebookSocialMedia($arg);
        break;
      case self::INSTAGRAM:
      default:
        $social_media = new InstagramSocialMedia($arg);
        break;
    }

    return $social_media;
  }
}

?>
