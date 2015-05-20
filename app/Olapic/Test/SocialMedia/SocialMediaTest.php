<?php

namespace Olapic\Test\SocialMedia;

use Olapic\Test\Helper\MediaTest;
use Olapic\SocialMedia\SocialMedia;
use Olapic\SocialMedia\SocialMediaNetwork;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

class SocialMediaTest extends MediaTest 
{
  const PARAM_TEST = "test_param";
  const PARAM_TEST_VALUE = "value";

  protected $media_id = 12;
  protected $social = false;

  public function setUp()
  { 
    parent::setUp();     
 
    $this->social = new SocialMedia(array(self::PARAM_TEST => self::PARAM_TEST_VALUE));
  }

  public function testArguments() {
    $arg = $this->social->getArgument();
    
    $this->assertTrue(isset($arg[self::PARAM_TEST]) && $arg[self::PARAM_TEST] == self::PARAM_TEST_VALUE);
  }

  public function testNetwork() {
    $this->assertFalse($this->social->getNetwork());
  }
  
  public function testSetterNetwork() 
  {
    $this->social->setNetwork(SocialMediaNetwork::INSTAGRAM);
    
    $this->assertTrue($this->social->getNetwork() == SocialMediaNetwork::INSTAGRAM);
  }

  public function testInstagramLocation()
  {
    $this->social->setNetwork(SocialMediaNetwork::INSTAGRAM);
    $this->social->getLocation($this->media_id, $this->getArguments());
    
    $this->assertTrue($this->social->getSocialMedia() instanceof InstagramSocialMedia);
  }

  protected function getArguments(){
    $arg = array();
    $arg[InstagramSocialMedia::PARAM_ACCESS_TOKEN] = $this->instagram_access_token;
    $arg[FacebookSocialMedia::PARAM_ACCESS_TOKEN] = $this->facebook_access_token;
    
    return $arg;
   }
}
?>
