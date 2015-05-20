<?php

namespace Olapic\Test\SocialMedia;

use Olapic\Test\Helper\MediaTest;
use Olapic\SocialMedia\SocialMedia;
use Olapic\SocialMedia\SocialMediaNetwork;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

class SocialMediaNetworkTest extends MediaTest 
{
  public function testCreateSocialMediaEmptyParam()
  {
    $social = SocialMediaNetwork::create_social_media(false);

    $this->assertTrue($social instanceof InstagramSocialMedia);

  }

  public function testCreateSocialMediaEmptyArray()
  {
    $social = SocialMediaNetwork::create_social_media(array());

    $this->assertTrue($social instanceof InstagramSocialMedia);
  }
  
  public function testCreateSocialMediaInstagram()
  {
    $social = SocialMediaNetwork::create_social_media(array(SocialMedia::PARAM_NETWORK => SocialMediaNetwork::INSTAGRAM));

    $this->assertTrue($social instanceof InstagramSocialMedia);
  }
  
  public function testCreateSocialMediaFacebook()
  {
    $social = SocialMediaNetwork::create_social_media(array(SocialMedia::PARAM_NETWORK => SocialMediaNetwork::FACEBOOK));

    $this->assertTrue($social instanceof FacebookSocialMedia);
  }
}
?>
