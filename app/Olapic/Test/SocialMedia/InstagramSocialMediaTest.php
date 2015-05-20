<?php

namespace Olapic\Test\SocialMedia;

use Olapic\Test\Helper\MediaTest;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

class InstagramSocialMediaTest extends MediaTest 
{ 
  protected $media_id=12;
  protected $media_id_without_location=21;

  public function testGetLocationEmptyParam()
  { 
    $this->setExpectedException('\Exception');
    $instagram = new InstagramSocialMedia(false);
    $location = $instagram->getLocation(false);
  } 
 
  public function testGetLocationEmptyTokenEmptyMediaID()
  { 
    $this->setExpectedException('\Exception');
    $instagram = new InstagramSocialMedia(array());
    $location = $instagram->getLocation(0);
  } 

  public function testGetLocationWithoutToken()
  {
    $this->setExpectedException('\Exception');
    $instagram = new InstagramSocialMedia(false);
    $location = $instagram->getLocation($this->media_id);
  } 
  
  public function testGetLocationWithoutMediaID()
  {
    $this->setExpectedException('\Exception');
    $instagram = new InstagramSocialMedia($this->getArguments());
    $location = $instagram->getLocation(0);
  }
 
  public function testGetLocationMediaWithoutLocation()
  {
    $instagram = new InstagramSocialMedia($this->getArguments());
    
    $json = $instagram->getLocation($this->media_id_without_location);
    
    $this->assertFalse($json);
  }

  public function testGetLocationMediaWithLocation()
  {
    $instagram = new InstagramSocialMedia($this->getArguments());
    $json = $instagram->getLocation($this->media_id);
    
    $this->assertArrayResponse($json);
  }
 
  protected function getArguments(){
    $arg = array();
    $arg[InstagramSocialMedia::PARAM_ACCESS_TOKEN] = $this->instagram_access_token;
    $arg[FacebookSocialMedia::PARAM_ACCESS_TOKEN] = $this->facebook_access_token;
 
    return $arg;
   }

  protected function assertArrayResponse($json)
  { 
    $this->assertTrue(isset($json["id"]));
    $this->assertLocation($json); 
  }

  protected function assertGeopoint($json)
  {
    $this->assertTrue(isset($json["location"]));
    $this->assertTrue(isset($json["location"]["geopoint"]));
    $this->assertTrue(isset($json["location"]["geopoint"]["latitude"]));
    $this->assertTrue(isset($json["location"]["geopoint"]["longitude"]));
  }

  protected function assertLocation($json)
  {    
    $this->assertGeopoint($json);

    $this->assertTrue(isset($json["location"]["street"]));
    $this->assertTrue(isset($json["location"]["city"]));
    $this->assertTrue(isset($json["location"]["state"]));
    $this->assertTrue(isset($json["location"]["country"]));
    $this->assertTrue(isset($json["location"]["zip"]));
    $this->assertTrue(isset($json["location"]["latitude"]));
    $this->assertTrue(isset($json["location"]["longitude"]));
  }
}
?>
