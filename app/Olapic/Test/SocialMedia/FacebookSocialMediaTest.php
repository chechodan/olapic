<?php

namespace Olapic\Test\SocialMedia;

use Olapic\Test\Helper\MediaTest;
use Olapic\SocialMedia\FacebookSocialMedia;

class FacebookSocialMediaTest extends MediaTest
{
  public function testGetLocation()
  {
    $this->setExpectedException('\Exception');
    $facebook = new FacebookSocialMedia(false);
    $facebook->getLocation(0);
  } 

  public function testGetLocationInfoEmptyParam()
  {
    $lat = "";
    $lng = "";
    $access_token = $this->facebook_access_token;
    
    $this->assertGeopointLatLng(FacebookSocialMedia::getLocationInfo($lat, $lng, $access_token), $lat, $lng);
  }

  public function testGetLocationInfoGarbageParam()
  {
    $lat = "aaaa";
    $lng = "bbbb";
    $access_token = $this->facebook_access_token;
    
    $this->assertGeopointLatLng(FacebookSocialMedia::getLocationInfo($lat, $lng, $access_token), $lat, $lng);
  }

  public function testGetLocationInfoErrorParam()
  {
    $lat = "0";
    $lng = "0";
    $access_token = $this->facebook_access_token;
    
    $this->assertGeopointLatLng(FacebookSocialMedia::getLocationInfo($lat, $lng, $access_token), $lat, $lng);
  }
  
public function testGetLocationInfo()
  {
    $lat = "37.777348";
    $lng = "-122.404654";
    $access_token = $this->facebook_access_token;
    
    $this->assertLocationLatLng(FacebookSocialMedia::getLocationInfo($lat, $lng, $access_token), $lat, $lng);     
  }
 
  protected function assertGeopointLatLng($json, $lat, $lng)
  {
    $this->assertGeopoint($json);
    $this->assertTrue($json["geopoint"]["latitude"] == $lat);
    $this->assertTrue($json["geopoint"]["longitude"] == $lng);
  }

  protected function assertLocationLatLng($json, $lat, $lng)
  {
    $this->assertLocation($json);
    $this->assertTrue($json["geopoint"]["latitude"] == $lat);
    $this->assertTrue($json["geopoint"]["longitude"] == $lng);
  }

  protected function assertGeopoint($json)
  {
    $this->assertTrue(isset($json["geopoint"]));
    $this->assertTrue(isset($json["geopoint"]["latitude"]));
    $this->assertTrue(isset($json["geopoint"]["longitude"]));
  }

  protected function assertLocation($json)
  {    
    $this->assertGeopoint($json);

    $this->assertTrue(isset($json["street"]));
    $this->assertTrue(isset($json["city"]));
    $this->assertTrue(isset($json["state"]));
    $this->assertTrue(isset($json["country"]));
    $this->assertTrue(isset($json["zip"]));
    $this->assertTrue(isset($json["latitude"]));
    $this->assertTrue(isset($json["longitude"]));
  }
}
?>
